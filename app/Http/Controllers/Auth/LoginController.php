<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    public function username(){
        return 'username';
    }

    public function credentials(Request $request){
        $request['activo'] = 1;
        $credentials = $request->only($this->username(), 'password','activo');
        
        return $credentials;
    }

    protected function authenticated(Request $request, $user)
    {
        if(!session('roles')){
            session(['roles'=>true]);
            foreach($user->roles as $rol){
                session([$rol->nombre=>$rol]);
            }
        }

        return redirect()->intended('/home');

    }
}
