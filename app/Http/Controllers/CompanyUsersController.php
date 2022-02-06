<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\SendEmailService;
use App\Http\Services\CompanyUsersService;
use App\Models\User;
use App\Models\RequestUser;
use App\Models\ModelHasRole;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyUsersController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::where('company', $user->company)
            ->get();
        return view('companyUsers.index', compact('users'));
    }

    public function admin()
    {
        $user = Auth::user();

        // Pobieram bezpośrednio z bazy danych usera z rolą
        $users = DB::table('users')
            ->select('users.id','users.email','roles.name', 'users.deleted_at')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.company', Auth::user()->company)
            ->get();

        return view('companyUsers.admin', compact('users'));
    }

    public function show($userId)
    {
        $user = Auth::user();
        $showUser = CompanyUsersService::getUserById($userId, $user);
        $modelHasRole = ModelHasRole::where('model_id',$userId)
            ->first();
        $role = Role::where('id', $modelHasRole->role_id)
            ->first()->name;

        return view('companyUsers.show', compact('showUser', 'role'));
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $email = $request->input('email');
        $key = Str::random(40);
        $requestUser = new RequestUser([
            'email' => $email,
            'key' => $key,
            'company' => $user->company,
        ]);
        try {
            $requestUser->save();
            SendEmailService::sendEmail($email,$key);
            return redirect()->route('companyUsers.admin')
                ->with('success', 'Pomyślnie zaproszono nowego użytkownika');
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('companyUsers.admin')
                        ->with('error', 'Błąd podczas zaproszenia nowego użytkownika! Użytkownik z tym adresem email już był zaproszony!');
                    break;
                default:
                    return redirect()->route('companyUsers.admin')
                        ->with('error', 'Błąd podczas zaproszenia nowego użytkownika!');
            }
        }

    }

    public function edit($userId)
    {
        $user = Auth::user();
        $editedUser = CompanyUsersService::getUserById($userId,$user);
        $modelHasRole = ModelHasRole::where('model_id',$userId)
            ->first();
        $role = Role::where('id', $modelHasRole->role_id)
            ->first()->name;

        //Pobranie wszystkich roli z wyjątkiem SuperAdministrator'a
        $roles = Role::whereNotIn('id',[1])
            ->get();

        return view('companyUsers.edit', compact('editedUser', 'role', 'roles'));
    }

    public function update(Request $request, $userId)
    {
        $user = Auth::user();
        try {
            $user = CompanyUsersService::getUserById($userId, $user);
            $modelHasRole = ModelHasRole::where('model_id', $userId)
                ->first();
            $newRole = $request->input('newRole');
            if($newRole == 1){
                return redirect()->route('companyUsers.admin')
                        ->with('error', 'Nie można nadać uprawnienia Super Administratora');
            }
            $modelHasRole->role_id = $newRole;
            $modelHasRole->save();
            return redirect()->route('companyUsers.admin')
                ->with('success', 'Pomyślnie edytowano uprawnienia użytkownika '.$user->email);
        } catch(\Illuminate\Database\QueryException $e) {
            switch($e->getCode()){
                case '23000':
                    return redirect()->route('companyUsers.admin')
                        ->with('error', 'Błąd podczas uprawnienia użytkownika '.$user->email);
                    break;
                default:
                    return redirect()->route('companyUsers.admin')
                        ->with('error', 'Błąd podczas uprawnienia użytkownika '.$user->email);
            }
        }
    }

    public function destroy($userId)
    {
        $user = Auth::user();
        $editedUser = CompanyUsersService::getUserById($userId, $user);
        try {
            $editedUser->delete();
        }
        catch (\Exception $e) {
            return redirect()->route('companyUsers.admin')
                ->with('error', 'Błąd podczas dezaktywowania użytkownika');
        }

        return redirect()->route('companyUsers.admin')
            ->with('success', 'Pomyślnie dezaktywowano konto użytkownika '.$editedUser->email);
    }

    public function restore($userId)
    {
        $user = Auth::user();
        $editedUser = CompanyUsersService::getUserById($userId, $user);
        if($editedUser === null)
        {
            return redirect()->route('companyUsers.admin')
                        ->with('error', 'Błąd podczas przywracania konta użytkownika!');
        }
        $editedUser->restore();
        return redirect()->route('companyUsers.admin')
            ->with('success', 'Pomyślnie przywrócono konto użytkownika '.$editedUser->email);
    }
}
