<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumnoParcial;

class AlumnoParcialController extends Controller
{
    // Funcionalidades
    public function __construct($foo = null)
    {
        $this->middleware('app.admin');
    }

    public function crear(
        int $alumno_id,
        int $parcial_id,
        int $porcentaje,
        int $nota
    ){
        $alumnoParcial = AlumnoParcial::where([
            'alumno_id' =>  $alumno_id,
            'parcial_id'=>  $parcial_id
        ])->first();

        if($alumnoParcial){
            $alumnoParcial->nota = $nota;
            $alumnoParcial->porcentaje_nota = $porcentaje;
            $alumnoParcial->update();
        }else{
            $alumnoParcial = new AlumnoParcial();
            $alumnoParcial->alumno_id = $alumno_id;
            $alumnoParcial->parcial_id = $parcial_id;
            $alumnoParcial->nota = $nota;
            $alumnoParcial->porcentaje_nota = $porcentaje;

            $alumnoParcial->save(); 
        }

        return response()->json(['status'=>'success'],200);
    }

    public function recuperatorio( 
        int $alumno_id,
        int $parcial_id,
        int $porcentaje,
        int $nota
    ){
        $alumnoParcial = AlumnoParcial::find($parcial_id);
        $alumnoParcial->recuperatorio = $nota;
        $alumnoParcial->porcentaje_recuperatorio = $porcentaje;
        $alumnoParcial->update();

        return response()->json(['status'=>'success'],200);
    }
}
