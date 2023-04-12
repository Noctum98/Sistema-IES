<?php

namespace App\Http\Controllers;

use App\Exports\AllAlumnosExport;
use App\Exports\AlumnosDatosExport;
use App\Exports\AlumnosYearExport;
use App\Exports\PlanillaNotasModularExport;
use App\Exports\PlanillaNotasTradicionalExport;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Materia;
use App\Models\Proceso;
use App\Services\AlumnoService;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    protected $alumnoService;

    public function __construct(
        AlumnoService $alumnoService
    )
    {
        $this->middleware('app.auth');
        $this->alumnoService = $alumnoService;
    }

    public function alumnos_year($carrera_id, $year,$ciclo_lectivo)
    {
        $alumnos = Alumno::alumnosAño($year, $carrera_id,$ciclo_lectivo);
        $generos = [
            'hombres'   => 0,
            'mujeres'   => 0,
            'otro'      => 0
        ];

        foreach ($alumnos as $alumno) {
            if ($alumno->genero == 'masculino') {
                $generos['hombres']++;
            } elseif ($alumno->genero == 'femenino') {
                $generos['mujeres']++;
            } else {
                $generos['otro']++;
            }
        }

        $carrera = Carrera::where('id', $carrera_id)->select('nombre')->first();

        return Excel::download(new AlumnosYearExport($alumnos, $generos,$ciclo_lectivo), 'Planilla de Alumnos de ' . $carrera->nombre . ' - Año ' . $year . '.xlsx');
    }

    public function all_alumnos($sede_id = null)
    {
        if ($sede_id) {
            $carreras = Carrera::where('sede_id', $sede_id)->get();
        } else {
            $carreras = Carrera::all();
        }

        return Excel::download(new AllAlumnosExport($carreras, $sede_id), 'Planilla de alumnos completa.xlsx');
    }

    public function alumnos_datos($carrera_id,$ciclo_lectivo = null)
    {
        $carrera = Carrera::where('id',$carrera_id)->first();
        
        $alumnos = $carrera->obtenerAlumnosCicloLectivo($ciclo_lectivo);

        return Excel::download(new AlumnosDatosExport($alumnos),'Planilla de datos '.$carrera->nombre.'.xlsx');
    }

    public function planilla_notas_tradicional($materia_id, $ciclo_lectivo ,$comision_id = null)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('procesos.ciclo_lectivo',$ciclo_lectivo);


        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }
        $materia = Materia::find($materia_id);

        $comision =  null;
        if ($comision_id) {
            $comision = Comision::find($comision_id);
        }


        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();
        
        $calificacion = Calificacion::where([
            'materia_id' => $materia_id
        ]);
        if ($comision_id) {
            $calificacion->where([
                'comision_id' => $comision_id
            ]);
        }
        $calificaciones = $calificacion->orderBy('tipo_id', 'DESC')->get();

        return Excel::download(new PlanillaNotasTradicionalExport($procesos,$calificaciones,$materia->carrera),'Planilla Notas '.$materia->nombre.' - '.$materia->carrera->nombre.'.xlsx');
    }

    public function planilla_notas_modular($materia_id, $comision_id = null)
    {

        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id);


        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }
        $materia = Materia::find($materia_id);

        $comision =  null;
        if ($comision_id) {
            $comision = Comision::find($comision_id);
        }


        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();

        return Excel::download(new PlanillaNotasModularExport($materia,$procesos),'Planilla Notas '.$materia->nombre.' - '.$materia->carrera->nombre.'.xlsx');
    }

    public function filtro_alumnos(Request $request)
    {
        //dd($request->all());

        $alumnos = $this->alumnoService->buscarAlumnos($request);

        return Excel::download(new AlumnosDatosExport($alumnos),'Planilla de datos.xlsx');
        //dd($alumnos);
    }
}
