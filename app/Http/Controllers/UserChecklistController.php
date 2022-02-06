<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use App\Models\UserChecklist;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Services\SendEmailService;
use App\Http\Services\UserChecklistService;
use App\Http\Services\GlobalChecklistService;
use App\Http\Services\UserService;

class UserChecklistController extends Controller
{
    public function index($userId)
    {
        $user = Auth::user();
        $companyUser = UserService::ifUserIsCompanyUser($user, $userId);
        $checklists = GlobalChecklistService::getGlobalChecklistFromUser($user);
        $userChecklists = UserChecklist::with('user_relation', 'checklist_category_relation', 'allocated_by_relation', 'global_checklist_relation')
            ->where('company', $user->company)
            ->where('user', $userId)
            ->get();
        return view('userChecklists.index', compact('userChecklists', 'user', 'userId', 'checklists', 'companyUser'));
    }

    public function add(Request $request, $userId)
    {
        $user = Auth::user();
        $request->validate([
            'file' => 'mimes:pdf,doc,docx,jpg,jpeg,odt,xls|max:2048'
            ]);
        $newChecklist = $request->input('new_checklist');
        $description = $request->input('description');
        $term = $request->input('term');
        //Ustawienie możliwości realizacji po terminie
        $allowAfterTerm = $request->filled('realizationAfterTerm');
        $companyUser = UserService::ifUserIsCompanyUser($user, $userId);
        $checklist = GlobalChecklistService::getGlobalChecklist($newChecklist, $user);
        $globalPoints = GlobalChecklistService::getGlobalPoints($newChecklist);
        UserChecklistService::addCopyTextAfterName($companyUser, $checklist);
        //Pobranie i zapis pliku
        $fileModel = new File;
        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();
        }
        $file = $fileModel->id;
        $userChecklist = new UserChecklist([
            'user' => $userId,
            'name' => $checklist->name,
            'description' => $description,
            'checklist_category' => $checklist->checklist_category,
            'allocated_by' => $user->id,
            'global_checklist' => $checklist->id,
            'company' => $user->company,
            'file' => $file,
            'term' => $term,
            'allowAfterTerm' => $allowAfterTerm
        ]);
        try {
            $userChecklist->save();
            SendEmailService::sendEmailAddChecklist($companyUser->email, $user->email, $checklist->name, $term);
            //Wyznaczenie ID nagłówka dla punktów
            $newId = $userChecklist->id;
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('userchecklists.index', $userId)
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
                return redirect()->route('userchecklists.index', $userId)
                    ->with('error', 'Błąd podczas dodawania punktów głównych listy kontrolnej!');
            }
            //Tylko dla podpunktów! Uzupełnienie zawartości kolumny user_point wcześniej przygotowanym indeksem.
            if ($point->master_point != null) {
                $userPoint->user_point = $newIdMasterPoint;
                try {
                    $userPoint->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    return redirect()->route('userchecklists.index', $userId)
                        ->with('error', 'Błąd podczas dodawania podpunktów listy kontrolnej!');
                }
            }

        }
        return redirect()->route('userchecklists.index', $userId)
            ->with('success', 'Pomyślnie dodano listę kontrolną do użytkownika!');
    }

    public function edit ($checklistId)
    {
        $companyUser = Auth::user();
        $checklist = UserChecklistService::getUserChecklist($checklistId, $companyUser);
        $userPoints = UserChecklistService::getPointsFromChecklist($checklistId);
        return view('userChecklists.edit', compact('checklist','userPoints','checklistId', 'companyUser'));
    }

    public function download($id)
    {
        $user = Auth::user();
        $checklist = UserChecklistService::getUserChecklist($id, $user);
        $file= storage_path(). '/app/public/uploads/'.$checklist->file_relation->name;
        return Response::download($file);
    }

    public function save (Request $request, $listId)
    {
        $user = Auth::user();
        $checklist = UserChecklistService::getUserChecklist($listId, $user);
        //Zapisanie starej nazwy i terminu do przekazania e-mailem.
        $oldName = $checklist->name;
        $oldTerm = $checklist->term;
        //Aktualizacja danych
        $checklist->name = $request->input('name');
        $checklist->description = $request->input('description');
        $checklist->term = $request->input('term');
        //Ustawienie możliwości realizacji po terminie
        $checklist->allowAfterTerm = $request->filled('realizationAfterTerm');
        //Dodanie napisu "Kopia" dla list, które mają taką samą nazwę i są przypisane do użytkownika
        $userChecklists = UserChecklist::with('user_relation','company_relation')
            ->where('user', $checklist->user)
            ->get();
        foreach ($userChecklists as $list) {
            if ($list->name == $checklist->name && $list->id != $checklist->id) {
                return redirect()->route('userchecklists.index', $checklist->user)
                    ->with('error', 'Taka nazwa listy kontrolnej dla tego użytkownika już istnieje!');
            }
        }
        try {
            $checklist->update();
            SendEmailService::sendEmailEditChecklist($checklist->user_relation->email, $user->email, $checklist->name, $checklist->term, $oldName, $oldTerm);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('userchecklists.index', $checklist->user)
                ->with('error', 'Błąd podczas zmiany nazwy listy kontrolnej!');
        }
        return redirect()->route('userchecklists.index', $checklist->user)
            ->with('success', 'Edytowano listę kontrolną!');
    }

    // Generuj PDF
    public function createPDF($checklistId)
    {
        $user = Auth::user();
        $userChecklist = UserChecklistService::getUserChecklist($checklistId, $user);
        $userPoints = UserChecklistService::getPointsFromChecklist($checklistId);

        //Udostępnienie danych do widoku
        view()->share('userChecklist', $userChecklist);
        view()->share('userPoints', $userPoints);
        view()->share('user', $user);
        $pdf = PDF::loadView('myChecklists.print', [$userChecklist, $userPoints, $user])->setOptions(['defaultFont' => 'DejaVu Sans']);
        //Pobranie pdf
        return $pdf->download('raport.pdf');
      }

    public function destroy($id, $userId)
    {
        $user = Auth::user();
        $userChecklist = UserChecklistService::getUserChecklist($id, $user);
        //Pobranie punktów podrzędnych
        $checklistSubPoints = UserChecklistService::getSubPointsFromChecklist($id);
        //Usunięcie punktów podrzędnych
        foreach ($checklistSubPoints as $point) {
            try {
                $point->delete();
            } catch (\Exception $e) {
                return redirect()->route('userchecklists.index', $userId)
                    ->with('error', 'Błąd podczas usuwania punktów z listy!');
            }
        }
        //Usunięcie punktów głównych
        $checklistPoints = UserChecklistService::getPointsFromChecklist($id);
        foreach ($checklistPoints as $point) {
            try {
                $point->delete();
            } catch (\Exception $e) {
                return redirect()->route('userchecklists.index', $userId)
                    ->with('error', 'Błąd podczas usuwania punktów z listy!');
            }
        }
        //Usunięcie nagłówka
        try {
            $userChecklist->delete();
            SendEmailService::sendEmailDeleteChecklist($userChecklist->user_relation->email, $user->email, $userChecklist->name);
        } catch (\Exception $e) {
            return redirect()->route('userchecklists.index', $userId)
                ->with('error', 'Błąd podczas usuwania nagłówka listy!');
        }
        return redirect()->route('userchecklists.index', $userId)
            ->with('success', 'Pomyślnie usunięto listę kontrolną użytkownika oraz punkty do niej przypisane!');
    }
}
