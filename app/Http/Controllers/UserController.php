<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Services\SendEmailService;
use App\Models\ModelHasRole;
use App\Models\Role;
use App\Models\RequestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //###################### FUNKCJE DOSTĘPNE DLA WSZYSTKICH UŻYTKOWNIKÓW ############################
    public function index(){
        $user = Auth::user();
        return view('auth.changePassword', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $oldPassword = $request->input('password');
        $check = Hash::check($oldPassword, $user->password);
        if ($check != true) {
            return redirect()->route('home')
                ->with('error', 'Stare hasło jest niezgodne!');
        }
        $newPassword = $request->input('password-new');
        $confirmPassword = $request->input('password-confirm');
        if ($newPassword != $confirmPassword) {
            return redirect()->route('home')
                ->with('error', 'Podano niezgodne nowe hasła!');
        }
        $newPasswordEncrypted = bcrypt($newPassword);
        $user->password = $newPasswordEncrypted;
        try {
            $user->update();
            return redirect()->intended('home')
                ->with('success', 'Pomyślnie zmieniono hasło!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('companyUsers.admin')
                ->with('error', 'Błąd podczas zmiany hasła!');
        }
    }

    //###################### FUNKCJE DOSTĘPNE DLA SUPER ADMINISTRATORA ############################
    public function allUsers(){
        $users = User::with('user_company_relation')->withTrashed()->get();
        $companies = Company::get();
        return view('users.allUsers', compact('users','companies'));
    }

    public function addAdmin($id){
        $user = User::findOrFail($id);
        try {
            //Pobranie z tablicy pośredniej użytkownika z nadaną rolą
            $modelHasRole = ModelHasRole::where('model_id', $id)
                ->first();
            //Wybranie roli administratora
            $newRole = 2;
            $modelHasRole->role_id = $newRole;
            $modelHasRole->save();
            return redirect()->route('users.allUsers')
                ->with('success', 'Pomyślnie nadano administratora firmowego dla użytkownika '.$user->email);
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('users.allUsers')
                        ->with('error', 'Błąd podczas nadawania administratora firmowego dla użytkownika '.$user->email);
                    break;
                default:
                    return redirect()->route('users.allUsers')
                        ->with('error', 'Błąd podczas nadawania administratora firmowego dla użytkownika '.$user->email);
            }
        }
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        try {
            $user->delete();
        }
        catch (\Exception $e) {
        }
        return redirect()->route('users.allUsers')
            ->with('success', 'Pomyślnie dezaktywowano konto użytkownika '.$user->email);
    }

    public function restore($id){
        $user = User::withTrashed()->find($id);
        if($user === null)
        {
            return redirect()->route('users.allUsers')
                ->with('error', 'Błąd podczas przywracania konta użytkownika!');
        }
        $user->restore();
        return redirect()->route('users.allUsers')
            ->with('success', 'Pomyślnie przywrócono konto użytkownika '.$user->email);
    }

    public function add(Request $request){
        $user = Auth::user();
        $email = $request->input('email');
        $company = $request->input('company');
        //Wygenerowanie tokenu/klucza
        $key = Str::random(40);
        $requestUser = new RequestUser([
            'email' => $email,
            'key' => $key,
            'company' => $company,
        ]);
        try {
            $requestUser->save();
            //Wysłanie e-maila z zaproszeniem oraz kluczem
            SendEmailService::sendEmail($email,$key);
            return redirect()->route('users.allUsers')
                ->with('success', 'Pomyślnie zaproszono nowego użytkownika');
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('users.allUsers')
                        ->with('error', 'Błąd podczas zaproszenia nowego użytkownika! Użytkownik z tym adresem email już był zaproszony!');
                    break;
                default:
                    return redirect()->route('users.allUsers')
                        ->with('error', 'Błąd podczas zaproszenia nowego użytkownika!');
            }
        }
    }

    public function show($id){
        $user = User::with('user_company_relation')
            ->withTrashed()
            ->findOrFail($id);
        $modelHasRole = ModelHasRole::where('model_id',$id)
            ->first();
        $role = Role::where('id', $modelHasRole->role_id)
            ->first();
        return view('users.show', compact('user','role'));
    }
}
