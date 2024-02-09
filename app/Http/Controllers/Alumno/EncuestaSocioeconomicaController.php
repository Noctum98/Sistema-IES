<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumno\EncuestaSocioeconomicaRequest;
use App\Mail\MatriculacionSuccessEmail;
use App\Models\Alumno;
use App\Models\Alumno\EncuestaSocioeconomica;
use App\Models\Carrera;
use App\Services\Alumno\EncuestaSocioeconomicaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function store2(Request $request)
    {
        $request = $this->encuestaSocioeconomicaService->procesarDatos2($request);
        $carrera = Carrera::find($request['carrera_id']);
        $encuestaSocioeconomica = EncuestaSocioeconomica::find($request['enc']);
        if($encuestaSocioeconomica)
        {
            $encuestaSocioeconomica->update($request->all());
        }

        Mail::to($request['email'])->send(new MatriculacionSuccessEmail($encuestaSocioeconomica->alumno, $carrera));
        $mensaje = "Felicidades te has matriculado correctamente a " . $carrera->nombre . " " . $carrera->sede->nombre;

        return view('matriculacion.card_finalizada', [
            'alumno' => $encuestaSocioeconomica->alumno,
            'mensaje' => $mensaje
        ]); 
    }
}
