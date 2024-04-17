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

    public function changeAño(Request $request,$inscripcion_id)
    {
        $validate = $this->validate($request,[
            'year' => ['required','numeric']
        ]);

        $request['año'] = $request['year'];
        $inscripcion = AlumnoCarrera::find($inscripcion_id);
        $inscripcion->update($request->all());


        $this->alumnoService->cambiarSituacion($inscripcion,$request['year'],$request['regularidad']);

        return redirect()->route('alumno.detalle',$inscripcion->alumno_id)->with('mensaje_exitoso','Datos modificados');
    }

    public function ver_datos_carrera($carrera, $alumno)
    {

    }
}
