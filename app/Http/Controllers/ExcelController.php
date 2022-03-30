<?php

namespace App\Http\Controllers;

use App\Exports\AlumnosAñoExport;
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

    public function alumnos_año($carrera_id,$year)
    {
        $alumnos = Alumno::alumnosAño($year,$carrera_id);

        $carrera = Carrera::find($carrera_id)->select('nombre')->first();

        return Excel::download(new AlumnosAñoExport($alumnos),'Planilla de Alumnos de '.$carrera->nombre.' - Año '.$year.'.xlsx');
    }
}
