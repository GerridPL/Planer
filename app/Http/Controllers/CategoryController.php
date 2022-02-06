<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Services\CategoryService;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = CategoryService::getCategoriesFromUser($user);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $user = Auth::user();
        $category = CategoryService::getCategoriesFromUser($user);
        return view('categories.create', compact('category'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        $category = new Category([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'company' => $user->company
        ]);
        try {
            $category->save();
            return redirect()->route('categories.index')
                ->with('success', 'Pomyślnie dodano nową kategorię '.$category->name);
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                default:
                    return redirect()->route('categories.index')
                        ->with('error', 'Błąd podczas dodawania nowej kategorii!');
            }
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $category = CategoryService::getCategoryById($id, $user);
        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $category = CategoryService::getCategoryById($id, $user);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        try {
            $category = CategoryService::getCategoryById($id, $user);
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->save();
            return redirect()->route('categories.index')
                ->with('success', 'Pomyślnie edytowano kategorię '.$category->name);
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                default:
                    return redirect()->route('categories.index')
                        ->with('error', 'Błąd podczas edycji kategorii!');
            }
        }
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        $category = CategoryService::getCategoryById($id, $user);
        try {
            $category->deactivated = true;
            $category->save();
        }
        catch (\Exception $e) {
        }

        return redirect()->route('categories.index')
            ->with('success', 'Pomyślnie dezaktywowano kategorię '.$category->name);
    }

    public function restore($id): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        $category = CategoryService::getCategoryById($id, $user);

        if($category === null)
        {
            return redirect()->route('categories.index')
                        ->with('error', 'Błąd podczas przywracania kategorii!');
        }
        //Przywrócenie kategorii
        $category->deactivated = false;
        $category->save();
        return redirect()->route('categories.index')
            ->with('success', 'Pomyślnie ponownie aktywowano kategorię '.$category->name);
    }
}
