<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumno\EncuestaSocioeconomicaRequest;
use App\Models\Alumno;
use App\Models\Alumno\EncuestaSocioeconomica;
use App\Models\Carrera;
use App\Services\Alumno\EncuestaSocioeconomicaService;
use Illuminate\Http\Request;

class EncuestaSocioeconomicaController extends Controller
{
    protected $encuestaSocioeconomicaService;
    public function __construct(
        EncuestaSocioeconomicaService $encuestaSocioeconomicaService
    )
    {
        $this->encuestaSocioeconomicaService = $encuestaSocioeconomicaService;
    }

    public function showForm(Request $request,$alumno_id,$carrera_id)
    {
        $alumno = Alumno::find($alumno_id);
        $carrera = Carrera::find($carrera_id);


        return view('alumno.encuesta_socioeconomica.form',['alumno'=>$alumno,'carrera'=>$carrera]);
    }

    public function showForm2(Request $request,$id,$carrera_id)
    {
        $encuestaSocioeconomica = EncuestaSocioeconomica::find($id);
        $carrera = Carrera::find($carrera_id);

        return view('alumno.encuesta_socioeconomica.form2',['encuesta_socioeconomica'=>$encuestaSocioeconomica,'carrera'=>$carrera]);
    }

    public function store(EncuestaSocioeconomicaRequest $request)
    {
        $request = $this->encuestaSocioeconomicaService->procesarDatos($request);
        $encuestaSocioeconomica = EncuestaSocioeconomica::create($request->all());
        $carrera_id = $request['carrera_id'];

        return redirect()->route('encuesta_socioeconomica.showForm2',['encuesta_id'=>$encuestaSocioeconomica->id,'carrera_id'=>$carrera_id]);
    }
}
