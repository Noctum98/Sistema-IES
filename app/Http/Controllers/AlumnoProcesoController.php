<?php

namespace App\Http\Controllers;

use App\Mail\BajaMesaMotivos;
use App\Models\Alumno;
use App\Models\Instancia;
use App\Models\Sede;
use App\Models\Carrera;
use App\Models\MesaAlumno;
use App\Models\Mesa;
use Illuminate\Http\Request;
use App\Mail\MesaEnrolled;
use App\Mail\MesaUnsubscribe;
use App\Models\Materia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AlumnoProcesoController extends Controller
{

    public function __construct()
    {
    }
    // Vistas

    public function vista_procesos(int $id){
        $alumno = Alumno::find($id);

        if(!$alumno)
        {
            return redirect()->route('alumno.admin')->with([
                'alumno_notIsset' => 'El alumno no existe'
            ]);
        }

        return view('proceso.alumno',[
            'alumno' => $alumno
        ]);
    }

}
