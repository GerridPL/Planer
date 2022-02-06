<?php

namespace App\Http\Controllers;

use App\Http\Services\UserChecklistService;
use App\Http\Services\MyChecklistService;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use App\Models\UserChecklist;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class MyChecklistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentDate = date("Y-m-d");
        $userId = $user -> id;
        $checklists = UserChecklistService::getUserChecklists($user);
        foreach($checklists as $checklist)
        {
            $term_date = $checklist->term;
            $datediff = date_diff(date_create($currentDate),date_create($term_date));
            if($datediff->invert == 1){
                $checklist->daysToRealization = $datediff -> format('%R%a');
            }
            else{
                $checklist->daysToRealization = $datediff -> format('%a');
            }
            try{
                $checklist->save();
            }
            catch (\Illuminate\Database\QueryException $e){
                return redirect()
                ->route('mychecklists.index')
                ->with('error', 'Nie można się połączyć z bazą danych w celu wyliczenia dni pozostałych do realizacji list kontrolnych!');
            }
        }
        return view('myChecklists.index', compact('user', 'checklists', 'userId', 'currentDate'));
    }

    //Wyświetl punkty do realizacji z wybranej listy kontrolnej
    public function realization($checklistId)
    {
        $user = Auth::user();
        $currentDate = date("Y-m-d");
        $userChecklist = UserChecklistService::getUserChecklist($checklistId, $user);
        if($userChecklist->term < $currentDate && $userChecklist->allowAfterTerm == false){
            return redirect()
                ->route('mychecklists.index')
                ->with('error', 'Nie możesz realizować tej listy po terminie!');
        }
        $userPoints = UserChecklistService::getPointsFromChecklist($checklistId);
        //Sprawdzam czy jest ustawiony jakikolwiek punkt jako aktywny
        $ifClear = true;
        foreach($userPoints as $point){
            if($point->active != null){
                $ifClear = false;
            }
            if($point->confirmed != null){
                $ifClear = false;
            }
        }
        //Ustawiam pierwszy punkt na aktywny jeżeli nie ma aktywnego punktu.
        if($ifClear == true){
            MyChecklistService::activeFirst($checklistId);
            //Ponowne wczytanie punktów, po aktualizacji aby wyświetlić ten aktywowany.
            $userPoints = UserChecklistService::getPointsFromChecklist($checklistId);
        }
        return view('myChecklists.realization', compact('userPoints','userChecklist'));
    }

    public function realize($pointId, $checklistId)
    {
        $user = Auth::user();
        $point = UserChecklistService::getUserPointByChecklistAndPointId($user, $checklistId, $pointId);
        if($point->active == 1){
            $point->confirmed = 1;
            $point->save();
            MyChecklistService::updatePercent($checklistId);
            //Dla niezrealizowanej listy szukam kolejnego punktu.
            MyChecklistService::activeNext($checklistId, $point);
            return redirect()
                ->route('mychecklists.realization', $checklistId)
                ->with('success', 'Pomyślnie zrealizowano punkt!');
        }
        else{
            return redirect()
                ->route('mychecklists.realization', $checklistId)
                ->with('error', 'Wybrany punkt nie jest obecnie aktywny!');
        }
    }

    public function undo($pointId, $checklistId)
    {
        $user = Auth::user();
        $point = UserChecklistService::getUserPointByChecklistAndPointId($user, $checklistId, $pointId);
        $point->confirmed = 0;
        $point->skiped = 1;
        $point->save();
        MyChecklistService::updatePercent($checklistId);
        return redirect()
            ->route('mychecklists.realization', $checklistId)
            ->with('success', 'Pomyślnie cofnięto realizację punktu!');
    }

    public function download($id)
    {
    $user = Auth::user();
    $checklist = UserChecklistService::getUserChecklist($id, $user);
    $file= storage_path(). '/app/public/uploads/'.$checklist->file_relation->name;
    return Response::download($file);
    }

    public function skip($pointId, $checklistId)
    {
        $user = Auth::user();
        $point = UserChecklistService::getUserPointByChecklistAndPointId($user, $checklistId, $pointId);
        if($point->active == 1){
            $point->skiped = 1;
            $point->save();
            //Dla niezrealizowanej listy szukam kolejnego punktu.
            MyChecklistService::activeNext($checklistId, $point);
            return redirect()
                ->route('mychecklists.realization', $checklistId)
                ->with('warning', 'Pomyślnie pominięto punkt!');
        }
        else
        {
            return redirect()
                ->route('mychecklists.realization', $checklistId)
                ->with('error', 'Wybrany punkt nie jest obecnie aktywny!');
        }
    }

    public function realizeskiped($pointId, $checklistId)
    {
        $user = Auth::user();
        $point = UserChecklistService::getUserPointByChecklistAndPointId($user, $checklistId, $pointId);
        if($point->skiped == 1)
        {
            $point->confirmed = 1;
            $point->skiped = 0;
            $point->save();
            MyChecklistService::updatePercent($checklistId);
            return redirect()
                ->route('mychecklists.realization', $checklistId)
                ->with('success', 'Pomyślnie zrealizowano pominięty punkt!');
        }
        else
        {
            return redirect()
                ->route('mychecklists.realization', $checklistId)
                ->with('error', 'Błąd podczas realizacji pominiętego punktu!');
        }
    }

    public function close(Request $request, $checklistId)
    {
        $user = Auth::user();
        $userChecklist = UserChecklistService::getUserChecklist($checklistId, $user);
        $description = $request->input('userComment');
        if(strlen($description)>500)
            return redirect()->route('mychecklists.realization', $checklistId)
                        ->with('error', 'Błąd podczas realizacji listy kontrolnej! Przekroczono dozwoloną długość komentarza wynoszącą 500 znaków!');
        $userChecklist->user_comment = $description;
        $userChecklist->status = 1;
        $currentDate = date("Y-m-d");
        $userChecklist->dateOfRealization = $currentDate;
        try {
            $userChecklist->save();
            return redirect()->route('mychecklists.index')
                ->with('success', 'Pomyślnie zrealizowano listę kontrolną '.$userChecklist->name);
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('mychecklists.index')
                        ->with('error', 'Błąd podczas realizacji listy kontrolnej!');
                    break;
                default:
                    return redirect()->route('mychecklists.index')
                        ->with('error', 'Błąd podczas realizacji listy kontrolnej!');
            }
        }
    }

    public function createPDF($checklistId) {
        $user = Auth::user();
        $userChecklist = UserChecklistService::getUserChecklist($checklistId, $user);
        $userPoints = UserChecklistService::getPointsFromChecklist($checklistId);
        //Udostępnij dane do widoku
        view()->share('userChecklist', $userChecklist);
        view()->share('userPoints', $userPoints);
        view()->share('user', $user);
        $pdf = PDF::loadView('myChecklists.print', [$userChecklist, $userPoints, $user])->setOptions(['defaultFont' => 'DejaVu Sans']);
        return $pdf->download('raport.pdf');
      }
}
