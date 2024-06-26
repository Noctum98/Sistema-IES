<?php

namespace App\Http\Controllers;

use App\Exports\AllAlumnosExport;
use App\Exports\AlumnosDatosExport;
use App\Exports\AlumnosYearExport;
use App\Exports\EncuestaExport;
use App\Exports\PlanillaNotasModularExport;
use App\Exports\PlanillaNotasTradicionalExport;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Materia;
use App\Models\Proceso;
use App\Services\Alumno\EncuestaSocioeconomicaService;
use App\Services\AlumnoService;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    protected $alumnoService;
    protected $encuestaSocioeconomicaService;

    public function __construct(
        AlumnoService $alumnoService,
        EncuestaSocioeconomicaService $encuestaSocioeconomicaService
    )
    {
        $this->middleware('app.auth');
        $this->alumnoService = $alumnoService;
        $this->encuestaSocioeconomicaService = $encuestaSocioeconomicaService;
    }

    public function encuesta_socioeconomica(Request $request, $carrera_id,$year,$general = null)
    {
        $datos = [
            'carrera_id' => $carrera_id,
            'año' => $year,
            'general' => $general
        ];

        if($datos['general'])
        {
            $nombreArchivo = 'Encuestas socioeconomicas IES 9015';
        }else{
            $carrera = Carrera::find($carrera_id);
            $nombreArchivo = $carrera->sede->nombre.' - '.$carrera->nombre.'('.$carrera->turno.') '.$year.'° año';
        }
        

        $encuestas = $this->encuestaSocioeconomicaService->getEncuestas($datos);

        return Excel::download(new EncuestaExport($encuestas),$nombreArchivo.'.xlsx');
    }

    public function alumnos_year($carrera_id, $year,$ciclo_lectivo,$comision_id = null)
    {
        $alumnos = Alumno::alumnosAño($year, $carrera_id,$ciclo_lectivo,$comision_id);
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

        $carrera = Carrera::find($carrera_id);

        return Excel::download(new AlumnosYearExport($alumnos, $generos,$ciclo_lectivo,$carrera,$year), 'Planilla de Alumnos de ' . $carrera->nombre . ' - Año ' . $year . '.xlsx');
    }

    public function all_alumnos(Request $request)
    {
        $alumnos = Alumno::where('aprobado',true)
        ->where('user_id','!=',null)->orderBy('apellidos')->get();

        return Excel::download(new AllAlumnosExport($alumnos), 'Planilla de alumnos completa.xlsx');
    }

    public function alumnos_datos($carrera_id,$ciclo_lectivo = null)
    {
        $carrera = Carrera::where('id',$carrera_id)->first();
        
        $alumnos = $carrera->obtenerAlumnosCicloLectivo($ciclo_lectivo);

        return Excel::download(new AlumnosDatosExport($alumnos,$carrera),'Planilla de datos '.$carrera->nombre.'.xlsx');
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
            'materia_id' => $materia_id,
            'ciclo_lectivo' => $ciclo_lectivo
        ]);
        if ($comision_id) {
            $calificacion->where([
                'comision_id' => $comision_id
            ]);
        }
        $calificaciones = $calificacion->orderBy('tipo_id', 'DESC')->get();

        return Excel::download(new PlanillaNotasTradicionalExport($procesos,$calificaciones,$materia->carrera),'Planilla Notas '.$materia->nombre.' - '.$materia->carrera->nombre.'.xlsx');
    }

    public function planilla_notas_modular($materia_id,$ciclo_lectivo,$comision_id = null)
    {

        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('ciclo_lectivo',$ciclo_lectivo);


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

        return Excel::download(new PlanillaNotasModularExport($materia,$procesos,$ciclo_lectivo),'Planilla Notas '.$materia->nombre.' - '.$materia->carrera->nombre.'.xlsx');
    }

    public function filtro_alumnos(Request $request)
    {
        //dd($request->all());

        $alumnos = $this->alumnoService->buscarAlumnos($request);

        return Excel::download(new AlumnosDatosExport($alumnos,null),'Planilla de datos.xlsx');
        //dd($alumnos);
    }
}
