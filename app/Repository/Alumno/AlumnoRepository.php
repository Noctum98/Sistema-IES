<?php

namespace App\Repository\Alumno;

use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Carrera;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Collection;

class AlumnoRepository
{

    public function getAlumnos()
    {
        return Alumno::all();
    }

    public function getAlumno($id)
    {
        return Alumno::find($id);
    }

    public function getAlumnoByCicloLectivo($ciclo_lectivo)
    {
        return Alumno::where('ciclo_lectivo', $ciclo_lectivo)->get();
    }

    public function getCarrerasByAlumno(int $id)
    {
        $ids = AlumnoCarrera::where('alumno_id', $id)->distinct()->get('carrera_id');
        return Carrera::whereIn('id', $ids)->get();
    }

    public function getAlumnoByDni($dni): Alumno
    {
        return Alumno::where('dni', $dni)->first();
    }

    public function getAlumnoByDniAndCicloLectivo($dni, $ciclo_lectivo): Alumno
    {
        return Alumno::where('dni', $dni)->where('ciclo_lectivo', $ciclo_lectivo)->first();
    }

    public function getAlumnoByDniAndCicloLectivoAndCarrera($dni, $ciclo_lectivo, $carrera_id): Alumno
    {
        return Alumno::where('dni', $dni)
            ->where('ciclo_lectivo', $ciclo_lectivo)->where('carrera_id', $carrera_id)->first();
    }

    public function getSedesByAlumno(int $id)
    {
        $carreras = $this->getCarrerasByAlumno($id)->pluck('sede_id')->toArray();
        return Sede::whereIn('id', $carreras)->get();
    }


}
