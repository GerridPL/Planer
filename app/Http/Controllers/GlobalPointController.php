<?php

namespace App\Http\Controllers;

use App\Http\Services\GlobalChecklistService;
use Illuminate\Http\Request;
use App\Models\GlobalPoint;
use Illuminate\Support\Facades\Auth;

class GlobalPointController extends Controller
{
    public function index($checklistId)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($checklistId, $user);
        $globalPoint = GlobalChecklistService::getGlobalPoints($checklistId);
        return view('globalPoints.index', compact('globalPoint','checklist','checklistId'));
    }

    public function create($checklistId)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($checklistId, $user);
        return view('globalPoints.create', compact('checklistId', 'checklist'));
    }

    public function createuper($index, $checklistId)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($checklistId, $user);
        $globalPoint = GlobalChecklistService::getGlobalPointsWhereIndex($checklistId, $index);
        return view('globalPoints.createuper', compact('index', 'checklistId', 'globalPoint'));
    }

    public function createsubsection($index, $checklistId)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($checklistId, $user);
        $globalPoint = GlobalChecklistService::getGlobalPointsWhereIndex($checklistId, $index);
        if($globalPoint->subIndex != null){
            return redirect()->route('globalpoints.index', $checklistId)
                        ->with('error', 'Nie można stworzyć podpunktu dla podpunktu!');
        }
        return view('globalPoints.createsubsection', compact('index', 'checklistId', 'globalPoint'));
    }

    public function moveup($id, $checklistId)
    {
        $user = Auth::user();
        GlobalChecklistService::getGlobalChecklist($checklistId, $user);
        $globalPoint = GlobalChecklistService::getGlobalPoint($checklistId, $id);
        //Sprawdzenie indexu pobranego punktu
        $index = $globalPoint ->index;
        if($index == 1)
        {
            return redirect()->route('globalpoints.index', $checklistId)
                ->with('error', 'Nie można podnieść pierwszego punktu!');
        }
        $globalPoints = GlobalChecklistService::getGlobalPoints($checklistId);
        foreach($globalPoints as $point)
        {
            if($point->index == $index)
            {
                $point->index = ($point->index) - 1;
                $point->save();
            }
            elseif ($point->index == $index -1)
            {
                $point->index = ($point->index) + 1;
                $point->save();
            }
        }
        return redirect()->route('globalpoints.index',$checklistId)
                ->with('success', 'Pomyślnie podniesiono punkt globalny');
    }

    public function movedown($id, $checklistId)
    {
        $user = Auth::user();
        GlobalChecklistService::getGlobalChecklist($checklistId, $user);
        $globalPoint = GlobalChecklistService::getGlobalPoint($checklistId, $id);
        //Sprawdzenie indexu pobranego punktu
        $index = $globalPoint ->index;
        $globalPoints = GlobalChecklistService::getGlobalPoints($checklistId);
        $maxIndex = 0;
        //Szukam obecnie największego indeksu (aby zwrócić błąd, gdy edytuję ostatni)
        foreach($globalPoints as $point){
            if($maxIndex < $point -> index)
                $maxIndex = $point -> index;
            }
        if($index == $maxIndex)
        {
            return redirect()->route('globalpoints.index', $checklistId)
                ->with('error', 'Nie można opóścić ostatniego punktu!');
        }
        foreach($globalPoints as $point)
        {
            if($point->index == $index)
            {
                $point->index = ($point->index) + 1;
                $point->save();
            }
            elseif ($point->index == $index + 1)
            {
                $point->index = ($point->index) - 1;
                $point->save();
            }
        }
        return redirect()->route('globalpoints.index',$checklistId)
                ->with('success', 'Pomyślnie opuszczono punkt globalny');
    }

    public function store(Request $request, $checklistId)
    {
        $user = Auth::user();
        $globalPoints = GlobalChecklistService::getGlobalPoints($checklistId);
        $maxIndex = 0;
        //Szukam obecnie największego indeksu (aby przy zapisaniu dać o jeden więcej)
        foreach($globalPoints as $point){
            if($maxIndex < $point -> index)
                $maxIndex = $point -> index;
            }
        $globalPoint = new GlobalPoint([
            'index' => $maxIndex + 1,
            'description' => $request->input('description'),
            'checklist' => $checklistId,
            'company' => $user->company,
            'point' => null
        ]);
        try {
            $globalPoint->save();
            return redirect()->route('globalpoints.index',$globalPoint->checklist)
                ->with('success', 'Dodano nowy punkt globalny');
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('globalpoints.index',$globalPoint->checklist)
                        ->with('error', 'Błąd podczas dodawania nowego punktu glpobalnego!');
                    break;
                default:
                    return redirect()->route('globalpoints.index',$globalPoint->checklist)
                        ->with('error', 'Błąd podczas dodawania nowego punktu globalnego!');
            }
        }
    }

    public function storeuper(Request $request, $index, $checklistId)
    {
        $user = Auth::user();
        $globalPoints = GlobalChecklistService::getGlobalPoints($checklistId);
        $globalPoint = new GlobalPoint([
            'index' => $index,
            'description' => $request->input('description'),
            'checklist' => $checklistId,
            'company' => $user->company,
            'point' => null
        ]);
        $globalPoints = GlobalChecklistService::getGlobalPoints($globalPoint->checklist);
        // Szukam po wszystkich punktach czy są z większym/równym indeksem i ew. dodaje 1 do każdego
        foreach($globalPoints as $point){
            if($point->index >= $index){
                $point -> index = ($point->index)+1;
                $point->save();
            }
        }
        try {
            $globalPoint->save();
            return redirect()->route('globalpoints.index', $checklistId)
                ->with('success', 'Dodano nowy punkt globalny');
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('globalpoints.index', $checklistId)
                        ->with('error', 'Błąd podczas dodawania nowego punktu glpobalnego!');
                    break;
                default:
                    return redirect()->route('globalpoints.index', $checklistId)
                        ->with('error', 'Błąd podczas dodawania nowego punktu globalnego!');
            }
        }
    }

    public function storesubsection(Request $request, $index, $checklistId)
    {
        $user = Auth::user();
        $globalPoints = GlobalPoint::with('checklist')
            ->where('checklist', $checklistId)
            ->where('index',$index)
            ->get();
        $globalPointIndex = GlobalChecklistService::getGlobalPointsWhereIndex($checklistId, $index);
        $maxSubIndex = 0;
        //Szukam maksymalnego podpunktu
        foreach($globalPoints as $point){
            if($maxSubIndex < $point -> subIndex)
                $maxSubIndex = $point -> subIndex;
            }
        $globalPoint = new GlobalPoint([
            'index' => $index,
            'subIndex' => $maxSubIndex + 1,
            'description' => $request->input('description'),
            'checklist' => $checklistId,
            'company' => $user->company,
            'point' => $globalPointIndex->id
        ]);
        try {
            $globalPoint->save();
            return redirect()->route('globalpoints.index', $checklistId)
                ->with('success', 'Dodano nowy podpunkt dla punktu '.$globalPointIndex->description);
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){

                case '23000':
                    return redirect()->route('globalpoints.index', $checklistId)
                        ->with('error', 'Błąd podczas dodawania nowego podpunktu!');
                    break;
                default:
                    return redirect()->route('globalpoints.index', $checklistId)
                        ->with('error', 'Błąd podczas dodawania nowego podpunktu!');
            }
        }
    }

    public function edit($id, $checklistId)
    {
        $user = Auth::user();
        $globalPoint = GlobalChecklistService::getGlobalPoint($checklistId, $id);
        return view('globalPoints.edit', compact('globalPoint','checklistId'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $globalPoint = GlobalChecklistService::getGlobalPointByUserAndId($user, $id);
        $globalPoint->description = $request->input('description');
        try {
            $globalPoint->save();
            return redirect()->route('globalpoints.index',$globalPoint->checklist)
                ->with('success', 'Pomyślnie edytowano punkt globalny');
        } catch(\Illuminate\Database\QueryException $e) {
            // duplikacja klucza - jest to sprawdzane w regułach walidacji
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('globalpoints.index',$globalPoint->checklist)
                        ->with('error', 'Błąd podczas edycji punktu globalnego!');
                    break;
                default:
                    return redirect()->route('globalpoints.index',$globalPoint->checklist)
                        ->with('error', 'Błąd podczas edycji punktu globalnego!');
            }
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $globalPoint = GlobalChecklistService::getGlobalPointByUserAndId($user, $id);
        $index = $globalPoint -> index;
        $subIndex = $globalPoint -> subIndex;
        try {
            $globalPoint->delete();
        }
        catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('globalpoints.index',$globalPoint->checklist)
                        ->with('error', 'Błąd! Nie można usunąć punktu nadrzędnego!');
                    break;
                default:
                    return redirect()->route('globalpoints.index',$globalPoint->checklist)
                        ->with('error', 'Błąd podczas usuwania punktu globalnego!');
            }
        }
        //Aktualizacja indexów
        $globalPoints = GlobalChecklistService::getGlobalPoints($globalPoint->checklist);
        if($subIndex == null){
            foreach($globalPoints as $point){
                if($point->index > $index){
                    $point -> index = ($point->index)-1;
                    $point->save();
                }
            }
        }
        else{
            foreach($globalPoints as $point){
                if($point->index == $index){
                    if($point->subIndex > $subIndex){
                        $point->subIndex = ($point->subIndex)-1;
                        $point->save();
                    }
                }
            }
        }
        return redirect()->route('globalpoints.index',$globalPoint->checklist)
            ->with('success', 'Pomyślnie usunięto punkt globalny!');
    }
}
