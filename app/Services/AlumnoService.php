<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Parameters\CicloLectivo;
use App\Models\Proceso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AlumnoService
{

    public function buscarAlumnos($request)
    {

        $alumnos = new Alumno();

        if ($request['busqueda'] and trim($request['busqueda']) != '') {
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

    public function buscarAlumno($busqueda, $carrera_id = null, $ciclo_lectivo = null)
    {
        $alumno = Alumno::where([
            'dni' => $busqueda
        ])->first();

        $alumnoCarrera = AlumnoCarrera::where([
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera_id,
            'aprobado' => true
        ]);

        if ($ciclo_lectivo) {
            $alumnoCarrera = $alumnoCarrera->where('ciclo_lectivo', $ciclo_lectivo->year);
        }

        $alumnoCarrera = $alumnoCarrera->first();

        if ($alumno && $alumnoCarrera) {
            return $alumno;
        } else {
            return null;
        }
    }

    public function agregarComision($request, $alumno, $comision)
    {
        if ($request['detach'] == 'true') {
            $alumno->comisiones()->detach($comision);
            $mensaje = "Comisión desasignada.";
        } else {
            $alumno->comisiones()->attach($comision);
            $mensaje = "Comisión asignada.";
        }

        return $mensaje;
    }
    public function cambiarSituacion($inscrpcion, $año,$regularidad)
    public function buscarAlumnoParcial(int $search, int $carrera_id)
    {
        $alumno = Alumno::select('id',  'apellidos', 'nombres')
        ->where(
            'dni', 'like', '%' . $search . '%'
        )->get();

        $alumnoCarrera = AlumnoCarrera::where([
            'carrera_id' => $carrera_id,
            'aprobado' => true
        ])
            ->whereIn('alumno_id', $alumno->pluck('id')->toArray())
            ->get();


        if ($alumno && count($alumnoCarrera) > 0) {
            return $alumno;
        }
        return null;

    }

    public function cambiarSituacion($inscrpcion, $año, $regularidad)
    {
        if ($año == 1) {
            $regularidad = str_replace(['_primero', '_tercero', '_segundo'], '_primero', $regularidad);
        if ($año == 1) {
            $regularidad = str_replace(['_primero', '_tercero', '_segundo'], '_primero', $regularidad);

        }

        if ($año == 2) {
            $regularidad = str_replace(['_primero', '_tercero', '_segundo'], '_segundo', $regularidad);
        }

        if ($año == 3) {
            $regularidad = str_replace(['_primero', '_tercero', '_segundo'], '_tercero', $regularidad);
        }

        $inscrpcion->update(['regularidad' => $regularidad]);
    }

    public function getMaterias($idAlumno)
    {
//        return Materia::
    }

    public function getCarrerasByRol($user)
    {
        $sedes = $user->sedes;
        if (Session::has('admin') || Session::has('areaSocial') || Session::has('regente')) {

            if (Session::has('areaSocial')) {
                $sedesIds = $sedes->pluck('id')->toArray();
                $carreras = Carrera::whereIn('sede_id', $sedesIds)->orderBy('sede_id', 'asc')->get();
            } else {
                $carreras = Carrera::orderBy('sede_id', 'asc')->get();
            }
        } else {
            $carreras = $user->carreras;
        }

        return $carreras;
    }
}
