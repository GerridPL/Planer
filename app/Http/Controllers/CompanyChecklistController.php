<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalChecklist;
use App\Models\UserChecklist;
use App\Models\User;
use App\Models\UserPoint;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\SendEmailService;
use App\Http\Services\UserChecklistService;
use App\Http\Services\GlobalChecklistService;
use App\Http\Services\UserService;

class CompanyChecklistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $globalChecklists = GlobalChecklistService::getAllGlobalChecklist($user);
        return view('companyChecklists.index', compact('globalChecklists'));
    }

    public function users($listId)
    {
        $user = Auth::user();
        $userId = $user->id;
        $thisList = GlobalChecklistService::getGlobalChecklist($listId, $user);
        $users = UserService::getUsersFromCompanyByUser($user);
        $checklists = UserChecklistService::getChecklistsByGlobalChecklist($listId);
        return view('companyChecklists.users', compact('thisList', 'users', 'checklists', 'userId'));
    }

    public function status($listId)
    {
        $user = Auth::user();
        $thisList = GlobalChecklist::findOrFail($listId);
        $users = UserService::getUsersFromCompanyByUser($user);
        $usersWithChecklist = UserChecklistService::getUsersWithChecklist($user, $listId);
        $allUsersWithChecklist = $usersWithChecklist;
        $allLists = UserChecklistService::getChecklistsByGlobalChecklist($listId);
        return view('companyChecklists.status', compact('thisList', 'usersWithChecklist', 'allLists', 'allUsersWithChecklist'));
    }

    public function filtr(Request $request, $listId)
    {
        $user = Auth::user();
        $thisList = GlobalChecklistService::getGlobalChecklist($listId, $user);
        $filterUser = $request->input('user');
        $filterStatus = $request->input('status');

        if($filterUser != 0)
        {
            $users = User::with('user_company_relation')->where('company', $user->company)->findOrFail($filterUser);
        }
        else
        {
            $users = UserService::getUsersFromCompanyByUser($user);
        }

        if($filterUser != 0)
        {
            $usersWithChecklist = [User::with('user_company_relation')->where('company', $user->company)->findOrFail($filterUser)];
            $allUsersWithChecklist = UserChecklistService::getUsersWithChecklist($user, $listId);
        }
        else
        {
            $usersWithChecklist = UserChecklistService::getUsersWithChecklist($user, $listId);
            $allUsersWithChecklist = $usersWithChecklist;
        }

        if($filterStatus != 3)
        {
            $allLists = UserChecklist::where('global_checklist',$listId)->where('status',$filterStatus)->get();
        }
        else
        {
            $allLists = UserChecklistService::getChecklistsByGlobalChecklist($listId);
        }

        return view('companyChecklists.status', compact('thisList', 'usersWithChecklist', 'allLists', 'allUsersWithChecklist'));
    }

    public function assign($userId, $listId, $term)
    {
        $user = Auth::user();
        $companyUser = UserService::ifUserIsCompanyUser($user, $userId);
        $checklist = GlobalChecklistService::getGlobalChecklist($listId, $user);
        $globalPoints = GlobalChecklistService::getGlobalPoints($listId);
        UserChecklistService::addCopyTextAfterName($companyUser, $checklist);
        $userChecklist = new UserChecklist([
            'user' => $userId,
            'name' => $checklist->name,
            'checklist_category' => $checklist->checklist_category,
            'allocated_by' => $user->id,
            'global_checklist' => $checklist->id,
            'company' => $user->company,
            'term' => $term
        ]);
        try {
            $userChecklist->save();
            //Wyznaczenie ID nagłówka dla punktów
            $newId = $userChecklist->id;
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('companyChecklists.users', $listId)
                ->with('error', 'Błąd podczas dodawania nagłówka listy kontrolnej!');
        }
        //Pętla po wszystkich punktach listy globalnej
        foreach ($globalPoints as $point) {
            //Przygotowanie punktu lub podpunktu bez zawartości w kolumnie user_point (najpierw muszę wyznaczyć id punktu głównego)
            $userPoint = new UserPoint([
                'index' => $point->index,
                'subIndex' => $point->subIndex,
                'description' => $point->description,
                'user_checklist' => $newId,
                'company' => $user->company
            ]);
            try {
                $userPoint->save();
                //Wyznaczenie id dla ewentualnego podpunktu
                if ($point->master_point == null) {
                    $newIdMasterPoint = $userPoint->id;
                }

            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->route('companyChecklists.users', $listId)
                    ->with('error', 'Błąd podczas dodawania punktów głównych listy kontrolnej!');
            }
            //Tylko dla podpunktów! Uzupełnienie zawartości kolumny user_point wcześniej przygotowanym indeksem.
            if ($point->master_point != null) {
                $userPoint->user_point = $newIdMasterPoint;
                try {
                    $userPoint->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect()->route('companyChecklists.users', $listId)
                        ->with('error', 'Błąd podczas dodawania podpunktów listy kontrolnej!');
                }
            }
        }
        SendEmailService::sendEmailAddChecklist($companyUser->email, $user->email, $checklist->name, $term);
        return redirect()->route('companyChecklists.users', $listId)
            ->with('success', 'Pomyślnie dodano listę kontrolną do użytkownika!');
    }

    public function edit ($checklistId)
    {
        $companyUser = Auth::user();
        $checklist = UserChecklistService::getCompanyUserChecklists($companyUser, $checklistId);
        $userPoints = UserChecklistService::getPointsFromChecklist($checklistId);
        return view('companyChecklists.edit', compact('checklist','userPoints','checklistId','companyUser'));
    }

    public function save (Request $request, $listId)
    {
        $user = Auth::user();
        $checklist = UserChecklistService::getCompanyUserChecklists($user, $listId);
        //Zapisanie starej nazwy i terminu do przekazania e-mailem.
        $oldName = $checklist->name;
        $oldTerm = $checklist->term;
        $checklist->name = $request->input('name');
        $checklist->description = $request->input('description');
        $checklist->term = $request->input('term');
        $allowAfterTerm = $request->filled('realizationAfterTerm');
        $checklist->allowAfterTerm = $allowAfterTerm;
        UserChecklistService::addCopyTextAfterName($user, $checklist);
        try {
            $checklist->update();
            SendEmailService::sendEmailEditChecklist($checklist->user_relation->email, $user->email, $checklist->name, $checklist->term, $oldName, $oldTerm);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('companyChecklists.users', $checklist->global_checklist)
                ->with('error', 'Błąd podczas zmiany nazwy listy kontrolnej!');
        }
        return redirect()->route('companyChecklists.users', $checklist->global_checklist)
            ->with('success', 'Edytowano listę kontrolną!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $userChecklist = UserChecklistService::getCompanyUserChecklists($user, $id);
        $checklistSubPoints = UserChecklistService::getSubPointsFromChecklist($id);
        //Usunięcie punktów podżędnych
        foreach ($checklistSubPoints as $point) {
            try {
                $point->delete();
            } catch (\Exception $e) {
                return redirect()->route('companyChecklists.users', $userChecklist->global_checklist)
                    ->with('error', 'Błąd podczas usuwania punktów z listy!');
            }
        }
        $checklistPoints = UserChecklistService::getPointsFromChecklist($id);
        //Usunięcie punktów głównych
        foreach ($checklistPoints as $point) {
            try {
                $point->delete();
            } catch (\Exception $e) {
                return redirect()->route('companyChecklists.users', $userChecklist->global_checklist)
                    ->with('error', 'Błąd podczas usuwania punktów z listy!');
            }
        }
        //Usunięcie nagłówka
        try {
            $userChecklist->delete();
            SendEmailService::sendEmailDeleteChecklist($userChecklist->user_relation->email, $user->email, $userChecklist->name);
        } catch (\Exception $e) {
            return redirect()->route('companyChecklists.users', $userChecklist->global_checklist)
                ->with('error', 'Błąd podczas usuwania nagłówka listy!');
        }
        return redirect()->route('companyChecklists.users', $userChecklist->global_checklist)
            ->with('success', 'Pomyślnie usunięto listę kontrolną użytkownika oraz punkty do niej przypisane!');
    }
}
