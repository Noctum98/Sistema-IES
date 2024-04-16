<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthorizerService;
use App\Services\AvisosService;
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
    private AvisosService $avisosService;

    /**
     * @param AvisosService $avisosService
     */
    public function __construct(AvisosService $avisosService
    )
    {
        $this->middleware('auth');
        $this->avisosService = $avisosService;
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

        $avisos = $this->avisosService->getAvisos();






        return view('home', compact('avisos'));
    }

    public function ayudaCargos()
    {
        return view('componentes.cargos.ayuda');
    }
    public function ayudaVisual()
    {
        return view('componentes.cargos.ayuda-visual');
    }
}
