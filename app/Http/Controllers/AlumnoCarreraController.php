<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Services\AlumnoService;
use Illuminate\Http\Request;

class AlumnoCarreraController extends Controller
{

    protected $alumnoService;

    public function __construct(
        AlumnoService $alumnoService
    )
    {
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente');
        $this->alumnoService = $alumnoService;
    }

    public function changeAño(Request $request,$alumno_id,$carrera_id)
    {
        $validate = $this->validate($request,[
            'year' => ['required','numeric']
        ]);


        $alumnoCarrera = AlumnoCarrera::where([
            'alumno_id' => $alumno_id,
            'carrera_id' => $carrera_id
        ])->latest()->first();

        $request['año'] = $request['year'];

        $alumnoCarrera->update($request->all());

        $alumno = Alumno::find($alumno_id);

        $this->alumnoService->cambiarSituacion($alumno,$request['year']);

        return redirect()->route('alumno.detalle',$alumno_id)->with('mensaje_exitoso','Año editado');
    }

    public function ver_datos_carrera($carrera, $alumno)
    {

    }
}
