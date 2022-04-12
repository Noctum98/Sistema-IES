<?php

namespace App\Http\Controllers;

use App\Models\AlumnoCarrera;
use Illuminate\Http\Request;

class AlumnoCarreraController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente');
    }

    public function changeAño(Request $request,$alumno_id,$carrera_id)
    {
        $validate = $this->validate($request,[
            'year' => ['required','numeric']
        ]);

        $alumnoCarrera = AlumnoCarrera::where([
            'alumno_id' => $alumno_id,
            'carrera_id' => $carrera_id
        ])->first();

        $request['año'] = $request['year'];

        $alumnoCarrera->update($request->all());

        return redirect()->route('alumno.detalle',$alumno_id)->with('mensaje_exitoso','Año editado');
    }
}
