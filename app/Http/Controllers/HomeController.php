<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthorizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $roles;
    public function __construct(
    )
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(!session('roles')){
            session(['roles'=>true]);
            foreach(Auth::user()->roles as $rol){
                session([$rol->nombre=>$rol]);
            }
        }

        return view('home');
    }

    public function ayuda()
    {
        return view('componentes.ayuda');
    }
}
