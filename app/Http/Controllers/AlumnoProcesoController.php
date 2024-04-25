<?php

namespace App\Http\Controllers;

use App\Mail\BajaMesaMotivos;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Instancia;
use App\Models\Proceso;
use App\Models\Sede;
use App\Models\Carrera;
use App\Models\MesaAlumno;
use App\Models\Mesa;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Mail\MesaEnrolled;
use App\Mail\MesaUnsubscribe;
use App\Models\Materia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AlumnoProcesoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    // Vistas

    /**
     * @param int $id
     * @param Carrera $carrera
     * @param int $year
     * @return Application|Factory|View|RedirectResponse
     */
    public function vista_procesos(int $id, Carrera $carrera, int $year)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return redirect()->route('alumno.admin')->with([
                'alumno_notIsset' => 'El alumno no existe'
            ]);
        }

        $procesos = [];
        $procesosGet = Proceso::select('procesos.*', 'alumno_carrera.cohorte')
            ->join('alumno_carrera', 'procesos.inscripcion_id', 'alumno_carrera.id')
            ->join('materias', 'procesos.materia_id', 'materias.id')
            ->where('materias.carrera_id', $carrera->id)
            ->where('materias.año', $year)
            ->where('procesos.alumno_id', $id)
            ->orderBy('materias.nombre', 'ASC')
            ->get();

        foreach ($procesosGet as $proceso) {
            $created_at = date('Y', strtotime($proceso->created_at));
            if ($created_at >= $proceso->cohorte) {
                $procesos[] = $proceso;
            }
        }

        return view('proceso.alumno', [
            'alumno' => $alumno,
            'procesos' => $procesos,
            'carrera' => $carrera,
            'year' => $year
        ]);
    }

    /**
     * @param int $idAlumno
     * @param int $idCarrera
     * @return Application|Factory|View|RedirectResponse
     */
    public function vistaProcesosPorCarrera(int $idAlumno, int $idCarrera)
    {

        $pase = false;
        $alumno = Alumno::find($idAlumno);
        if (Session::has('alumno')) {

            if (Auth::user()->id == $alumno->user->id) {
                $pase = true;
            }
        }
        if (
            Session::has('coordinador') || Session::has('admin') || Session::has('areaSocial')
            || Session::has('regente') || Session::has('seccionAlumnos')
        ) {
            $pase = true;
        }


        if (!$pase) {
            return view('alumno.detail', [
                'alumno' => $alumno,
                'carreras' => $alumno->carreras,
                'ciclo_lectivo' => date('Y')
            ]);
        }

        $carrera = Carrera::select('carreras.*')
            ->join('materias', 'materias.carrera_id', 'carreras.id')
            ->where('carreras.id', $idCarrera)
            ->orderBy('materias.nombre', 'ASC')
            ->first();


        if (!$alumno) {
            return redirect()->route('alumno.admin')->with([
                'alumno_notIsset' => 'No se encontró el alumno solicitado'
            ]);
        }

        if (!$carrera) {
            return redirect()->route('alumno.admin')->with([
                'alumno_notIsset' => 'No se encontró la carrera solicitada'
            ]);
        }

        $alumnoCarrera = AlumnoCarrera::where([
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera->id,
        ])->first();

        if (!$alumnoCarrera) {
            return redirect()->route('alumno.admin')->with([
                'alumno_notIsset' => 'No se encontró la carrera solicitada para el alumno indicado'
            ]);
        }

        return view('proceso.alumnoCarrera', [
            'alumno' => $alumno,
            'carrera' => $carrera
        ]);
    }
}
