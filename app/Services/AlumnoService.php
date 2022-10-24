<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Proceso;
use Illuminate\Support\Facades\DB;

class AlumnoService
{

    public function buscarAlumnos($request)
    {

        $alumnos = new Alumno();

        if ($request['busqueda']) {
            $alumnos = $alumnos->where(function ($query) use ($request) {
                $query->whereRaw(" CONCAT(nombres,' ',apellidos  ) like '" . $request['busqueda'] . "'")
                    ->orWhere('dni', 'LIKE', '%' . $request['busqueda'] . '%')
                    ->orWhere('nombres', 'LIKE', '%' . $request['busqueda'] . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $request['busqueda'] . '%')
                    ->orWhere('telefono', 'LIKE', '%' . $request['busqueda'] . '%')
                    ->orWhere('localidad', 'LIKE', '%' . $request['busqueda'] . '%');
            });
        }

        if ($request['cohorte']) {
            $alumnos = $alumnos->where('cohorte', $request['cohorte']);
        }

        if ($request['carrera_id']) {
            $alumnos = $alumnos->whereHas('carreras', function ($query) use ($request) {
                $query->where('carreras.id', $request['carrera_id']);
            });
        }

        if ($request['materia_id']) {
            $alumnos = $alumnos->whereHas('procesos', function ($query) use ($request) {
                $query->where('procesos.materia_id', $request['materia_id']);
            });
        }

        return $alumnos->get();
    }

    public function alumnosMateria($materia_id)
    {
        $procesos = Proceso::select('procesos.*', 'alumnos.id', 'alumnos.nombres', 'alumnos.apellidos')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)->orderBy('alumnos.apellidos')->get();

        //$procesos->nombres = ucwords($procesos->nombres);

        return $procesos;
    }

    public function buscarAlumno($busqueda, $carrera_id = null)
    {
        $alumno = Alumno::where([
            'dni' => $busqueda
        ])->first();

        if ($alumno && $alumno->hasCarrera($carrera_id)) {
            return $alumno;
        } else {
            return null;
        }
    }
}
