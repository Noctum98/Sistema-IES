<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumno\EncuestaSocioeconomicaRequest;
use App\Models\Alumno;
use App\Models\Alumno\EncuestaSocioeconomica;
use App\Models\Carrera;
use Illuminate\Http\Request;

class EncuestaSocioeconomicaController extends Controller
{
    public function showForm(Request $request,$alumno_id,$carrera_id)
    {
        $alumno = Alumno::find($alumno_id);
        $carrera = Carrera::find($carrera_id);


        return view('alumno.encuesta_socioeconomica.form',['alumno'=>$alumno,'carrera'=>$carrera]);
    }
    public function show(EncuestaSocioeconomicaRequest $request,$id)
    {

    }

    public function store(EncuestaSocioeconomicaRequest $request)
    {
        $encuestaSocioeconomica = EncuestaSocioeconomica::create($request->all());

    }
}
