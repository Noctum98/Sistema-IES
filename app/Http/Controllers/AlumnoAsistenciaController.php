<?php

namespace App\Http\Controllers;
use App\Models\AlumnoAsistencia;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AlumnoAsistenciaController extends Controller
{
    function __construct()
    {
        $this->middleware('app.admin');
    }
    // Funcionalidades
    public function crear(
        int $alumno_id,
        int $asistencia_id,
        string $estado
    ){
        $alumno_asis = AlumnoAsistencia::where([
            'alumno_id' =>  $alumno_id,
            'asistencia_id' =>  $asistencia_id
        ])->first();

        if(!$alumno_asis){
            $alumno_asis = new AlumnoAsistencia();
            $alumno_asis->alumno_id = $alumno_id;
            $alumno_asis->asistencia_id = $asistencia_id;
            $alumno_asis->estado = $estado;

            $alumno_asis->save();
        }else{
            $alumno_asis->estado = $estado;
            $alumno_asis->update();
        }

        $data = [
            'status'=>'success'
        ];
        return response()->json($data,200);
    }
}
