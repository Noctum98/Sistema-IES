<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Proceso;

class AlumnoService
{

    public function buscarAlumnos($busqueda)
    {
        $alumnos = Alumno::where('dni','LIKE','%'.$busqueda.'%')
                            ->orWhere('nombres','LIKE','%'.$busqueda.'%')
                            ->orWhere('apellidos','LIKE','%'.$busqueda.'%')
                            ->orWhere('telefono','LIKE','%'.$busqueda.'%')
                            ->orWhere('localidad','LIKE','%'.$busqueda.'%')
                            ->select('nombres','apellidos','id','dni')
                            ->get();
        return $alumnos;

    }

    public function alumnosMateria($materia_id)
    {
        $procesos = Proceso::select('procesos.*','alumnos.id','alumnos.nombres','alumnos.apellidos')
        ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
        ->where('procesos.materia_id', $materia_id)->orderBy('alumnos.apellidos')->get();

        //$procesos->nombres = ucwords($procesos->nombres);

        return $procesos;
    }

    public function buscarAlumno($busqueda,$carrera_id = null)
    {
        $alumno = Alumno::where([
            'dni' => $busqueda
        ])->first();

        if($alumno && $alumno->hasCarrera($carrera_id))
        {
            return $alumno;
        }else{
            return null;
        }
    }
}