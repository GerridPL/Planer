<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    //######################## Funkcje dla SuperAdministratora ###############################

    public function index()
    {
        $companies = Company::withTrashed()->get();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        $company = Company::all();
        return view('companies.create', compact('company'));
    }

    public function store(Request $request)
    {
        $company = new Company([
            'name' => $request->input('name'),
            'tax_number' => $request->input('tax_number'),
            'city' => $request->input('city'),
            'postcode' => $request->input('postcode'),
            'sub_exp_date' => $request->input('sub_exp_date'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone')
        ]);
        try {
            $company->save();
            return redirect()->route('companies.index')
                ->with('success', 'Dodano nową firmę ' . $company->name);
        } catch (\Illuminate\Database\QueryException $e) {
            switch ($e->getCode()) {
                case '23000':
                    return redirect()->route('companies.index')
                        ->with('error', 'Błąd, firma z tym numerem NIP już istnieje!');
                    break;
                default:
                    return redirect()->route('companies.index')
                        ->with('error', 'Błąd podczas dodawania nowej firmy!');
            }
        }
    }

    public function show($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        return view('companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        try {
            $company = Company::findOrFail($id);
            $company->name = $request->input('name');
            $company->tax_number = $request->input('tax_number');
            $company->city = $request->input('city');
            $company->postcode = $request->input('postcode');
            $company->sub_exp_date = $request->input('sub_exp_date');
            $company->email = $request->input('email');
            $company->phone = $request->input('phone');
            $company->save();
            return redirect()->route('companies.index')
                ->with('success', 'Pomyślnie edytowano firmę ' . $company->name);
        } catch (\Illuminate\Database\QueryException $e) {
            switch ($e->getCode()) {
                case '23000':
                    return redirect()->route('companies.index')
                        ->with('error', 'Błąd, firma z tym numerem NIP już istnieje!');
                    break;
                default:
                    return redirect()->route('companies.index')
                        ->with('error', 'Błąd podczas edycji firmy!');
            }
        }
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')
            ->with('success', 'Pomyślnie dezaktywowano firmę! ' . $company->name);
    }

    public function restore($id)
    {
        $company = Company::withTrashed()->find($id)->restore();
        return redirect()->route('companies.index')
            ->with('success', 'Pomyślnie ponownie aktywowano firmę ');
    }

    //######################## Funkcje dla Administratora ###############################

    public function editCompany()
    {
        $user = Auth::user();
        $company = Company::where('id',$user->company)
            ->first();
        return view('company.edit', compact('company'));
    }

    public function updateCompany(Request $request)
    {
        $user = Auth::user();
        $company = Company::where('id',$user->company)->first();
        try {
            $company = Company::findOrFail($company->id);
            // aktualizacja w bazie danych
            $company->name = $request->input('name');
            $company->tax_number = $request->input('tax_number');
            $company->city = $request->input('city');
            $company->postcode = $request->input('postcode');
            $company->email = $request->input('email');
            $company->phone = $request->input('phone');
            $company->save();
            // przekierowanie na stronę z informacją
            return redirect()->route('companyUsers.admin')
                ->with('success', 'Pomyślnie edytowano firmę.');
        } catch (\Illuminate\Database\QueryException $e) {
            // duplikacja klucza - jest to sprawdzane w regułach walidacji
            switch ($e->getCode()) {
                case '23000':
                    return redirect()->route('companyUsers.admin')
                        ->with('error', 'Błąd, firma z tym numerem NIP już istnieje!');
                    break;
                default:
                    return redirect()->route('companyUsers.admin')
                        ->with('error', 'Błąd podczas edycji firmy!');
            }
        }
    }

}
