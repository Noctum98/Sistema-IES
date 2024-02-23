<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Proceso;
use Illuminate\Support\Facades\DB;

class AlumnoService
{

    public function buscarAlumnos($request)
    {

        $alumnos = new Alumno();

        if ($request['busqueda'] and trim($request['busqueda']) != '' ) {
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

        $alumnoCarrera = AlumnoCarrera::where([
            'alumno_id'=>$alumno->id,
            'carrera_id' => $carrera_id
        ])->first();

        if ($alumno && $alumnoCarrera) {
            return $alumno;
        } else {
            return null;
        }
    }

    public function cambiarSituacion($alumno,$año)
    {
        if($año == 1)
        {
            $regularidad = str_replace(['_primero','_tercero','_segundo'],'_primero',$alumno->regularidad);

        }

        if($año == 2)
        {
            $regularidad = str_replace(['_primero','_tercero','_segundo'],'_segundo',$alumno->regularidad);
        }

        if($año == 3)
        {
            $regularidad = str_replace(['_primero','_tercero','_segundo'],'_tercero',$alumno->regularidad);
        }

        $alumno->update(['regularidad'=>$regularidad]);
    }

    public function getMaterias($idAlumno)
    {
//        return Materia::
    }
}
