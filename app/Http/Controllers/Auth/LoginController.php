<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function authenticated(Request $request, $user)
    {
        $company = Company::withTrashed()->where('id',$user->company)->first();
        if($company!= null && $company->trashed())
        {
            Auth::logout();
            return redirect('login')->with('error','Firma jest zablokowana, prosimy o kontakt z administratorem!');
        }
        return redirect()->intended('home');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}