<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\RequestUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showRegistrationForm($key=null)
    {
        if($key == null)
        {
            return false;
        }
        return view('auth.register', compact('key'));
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data, $key)
    {
        $email = $data['email'];
        //$inputKey = $data['key'];
        $RequestUser = RequestUser::where('email',$email)->first();
        if($RequestUser == null || $key == null || $RequestUser->key != $key){
            return null;
        }
        $company = $RequestUser->company;

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($data['password']),
            'company' => $company,
        ]);

        $role = Role::findByName(config('permission.roles.user'));

        if(isset($role)) {
            $user->assignRole($role);
        }

        return $user;
    }

    public function register(Request $request, $key)
    {

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all(),$key)));

        if($user == null){
            return redirect()->route('register.showRegistrationForm', $key)
                        ->with('error', 'Błąd rejestracji!');
        }

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }
}
