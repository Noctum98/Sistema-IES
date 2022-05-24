<?php

namespace App\Http\Controllers;

use App\Exports\AllAlumnosExport;
use App\Exports\AlumnosYearExport;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Carrera;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
    }

    public function alumnos_year($carrera_id,$year)
    {
        $alumnos = Alumno::alumnosAño($year,$carrera_id);
        $generos = [
            'hombres'   => 0,
            'mujeres'   => 0,
            'otro'      => 0
        ];

        foreach($alumnos as $alumno)
        {
            if($alumno->genero == 'masculino')
            {
                $generos['hombres']++;

            }elseif($alumno->genero == 'femenino')
            {
                $generos['mujeres']++;
                
            }else{
                $generos['otro']++;
            }
        }

        $carrera = Carrera::where('id',$carrera_id)->select('nombre')->first();
        
        return Excel::download(new AlumnosYearExport($alumnos,$generos),'Planilla de Alumnos de '.$carrera->nombre.' - Año '.$year.'.xlsx');
    }

    public function all_alumnos()
    {
        $carreras = Carrera::all();

        return Excel::download(new AllAlumnosExport($carreras),'Planilla de alumnos completa.xlsx');
    }
}
