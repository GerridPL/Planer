<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalChecklist;
use App\Models\GlobalPoint;
use App\Http\Services\GlobalChecklistService;
use App\Http\Services\CategoryService;
use Illuminate\Support\Facades\Auth;

class GlobalChecklistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $checklists = GlobalChecklistService::getAllGlobalChecklistWithTrashed($user);
        return view('globalChecklists.index', compact('checklists'));
    }

    public function copy(Request $request, $id)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($id, $user);
        $globalPoints = GlobalChecklistService::getGlobalPoints($id);
        $checklist = new GlobalChecklist([
            'name' => "$checklist->name Kopia",
            'author' => $user->id,
            'company' => $user->company,
            'checklist_category' => $checklist->checklist_category
        ]);
        try {
            $checklist->save();
            $newId = $checklist->id;
        } catch(\Illuminate\Database\QueryException $e) {
                return redirect()->route('globalChecklists.index')
                    ->with('error', 'Błąd podczas kopiowania nagłówka szablonu!');
            }
        foreach($globalPoints as $point){
            $globalPoint = new GlobalPoint([
                'index' => $point->index,
                'subIndex' => $point->subIndex,
                'description' => $point->description,
                'checklist' => $newId,
                'company' => $user->company,
                'point' => $point->point
            ]);
            try {
                $globalPoint->save();
            } catch(\Illuminate\Database\QueryException $e) {
                return redirect()->route('globalChecklists.index')
                    ->with('error', 'Błąd podczas dodawania nowego punktu globalnego!');
                }
            }
            return redirect()->route('globalpoints.index',$newId)
                    ->with('success', 'Pomyślnie skopiowano szablon wraz z punktami!');

    }

    public function create()
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getAllGlobalChecklist($user);
        $category = CategoryService::getCategoriesWithoutDeactivated($user);
        return view('globalChecklists.create', compact('checklist', 'category'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $checklist = new GlobalChecklist([
            'name' => $request->input('name'),
            'author' => $user->id,
            'company' => $user->company,
            'checklist_category' => $request->input('category')
        ]);
        try {
            $checklist->save();
            return redirect()->route('globalChecklists.index')
                ->with('success', 'Dodano nowy nagłówek szablonu');
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('globalChecklists.index')
                        ->with('error', 'Błąd podczas dodawania nagłówka szablonu!');
                    break;
                default:
                    return redirect()->route('globalChecklists.index')
                        ->with('error', 'Błąd podczas dodawania nagłówka szablonu!');
            }
        }
    }


    public function show($id)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($id, $user);
        return view('globalChecklists.show', compact('checklist'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($id, $user);
        $categories = CategoryService::getCategoriesWithoutDeactivated($user);
        return view('globalChecklists.edit', compact('checklist', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($id, $user);
        $checklist->name = $request->input('name');
        $checklist->checklist_category = $request->input('checklist_category');
        try {
            $checklist->save();
            return redirect()->route('globalpoints.index', $id)
                ->with('success', 'Pomyślnie edytowano nagłówek szablonu listy kontrolnej');
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('globalpoints.index', $id)
                        ->with('error', 'Błąd podczas edycji nagłówka szablonu listy kontrolnej!');
                    break;
                default:
                    return redirect()->route('globalpoints.index', $id)
                        ->with('error', 'Błąd podczas edycji nagłówka szablonu listy kontrolnej!');
            }
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklist($id, $user);
        try {
            $checklist->delete();
        }
        catch (\Exception $e) {
            return redirect()->route('globalChecklists.index')
                        ->with('error', 'Błąd podczas dezaktywacji szablonu listy kontrolnej!');
        }
        return redirect()->route('globalChecklists.index')
            ->with('success', 'Pomyślnie dezaktywowano nagłówek szablon listy kontrolnej!');
    }

    public function restore($id)
    {
        $user = Auth::user();
        $checklist = GlobalChecklistService::getGlobalChecklistWithTrashed($id, $user);
        if($checklist === null)
        {
            return redirect()->route('globalChecklists.index')
                ->with('error', 'Błąd podczas przywracania szablonu listy kontrolnej!');
        }
        $checklist->restore();
        return redirect()->route('globalChecklists.index')
            ->with('success', 'Pomyślnie ponownie aktywowano szablon listy kontrolnej');
    }
}
