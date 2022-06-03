<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador-profesor-regente');
    }

    public function home()
    {
        $user = Auth::user();
        // dd($user_id);
        $materias = $user->materias;
        $cargos = $user->cargos;
        $ruta = 'calificacion.admin';

        // dd($materias,$cargos);

        return view('calificacion.home',[
            'materias' => $materias,
            'cargos' => $cargos,
            'ruta' => $ruta
        ]);
    }

    public function admin($materia_id)
    {
        $materia = Materia::find($materia_id);
        $procesos = $materia->procesos;

        return view('calificacion.admin',[
            'materia' => $materia,
            'procesos' =>  $procesos
        ]);
    }
}
