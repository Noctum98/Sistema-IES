<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumnoTrabajo;

class AlumnoTrabajoController extends Controller
{
    function __construct()
    {
        $this->middleware('app.admin');
    }
    // Funcionalidades
    public function crear(
        int $alumno_id,
        int $trabajo_id,
        int $porcentaje,
        int $nota
    ){
        $alumnoTrabajo = AlumnoTrabajo::where([
            'alumno_id' =>  $alumno_id,
            'trabajo_id'=>  $trabajo_id
        ])->first();

        if($alumnoTrabajo){
            $alumnoTrabajo->nota = $nota;
            $alumnoTrabajo->porcentaje = $porcentaje;
            $alumnoTrabajo->update();
        }else{
            $alumnoTrabajo = new AlumnoTrabajo();
            $alumnoTrabajo->alumno_id = $alumno_id;
            $alumnoTrabajo->trabajo_id = $trabajo_id;
            $alumnoTrabajo->nota = $nota;
            $alumnoTrabajo->porcentaje = $porcentaje;

            $alumnoTrabajo->save(); 
        }

        return response()->json(['status'=>'success'],200);
    }
}
