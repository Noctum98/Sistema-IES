<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Asistencia;
use App\Models\AlumnoAsistencia;
use App\Models\Proceso;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    function __construct()
    {
        $this->middleware('app.admin');
        $this->middleware('app.roles:admin-profesor');
    }
    // Vistas
    public function vista_carreras(){
        $carreras = Auth::user()->carreras;
        $ruta = 'asis.admin';

        return view('asistencia.home',[
            'carreras'  =>  $carreras,
            'ruta'      =>  $ruta
        ]);
    }

    public function vista_admin(int $id){
        $materia = Materia::find($id);
        $asistecias = Asistencia::where('materia_id',$id)->get();

        return view('asistencia.admin',[
            'materia'       =>  $materia,
            'asistencias'   =>  $asistecias
        ]);
    }
    public function vista_fecha(int $id){
        $materia = Materia::find($id);

        return view('asistencia.date',[
            'materia'   =>  $materia
        ]);
    }
    public function vista_crear(int $id){
        $asistencia = Asistencia::find($id);
        $procesos = Proceso::where('materia_id',$asistencia->materia_id)->get();

        return view('asistencia.create',[
            'procesos'  =>  $procesos,
            'asistencia'   =>  $asistencia
        ]);
    }

    public function vista_cerrar(int $id){
        $procesos = Proceso::where('materia_id',$id)->get();
        $asistencias = Asistencia::where('materia_id',$id)->get();

        return view('asistencia.close',[
            'procesos'      =>  $procesos,
            'asistencias'   =>  $asistencias
        ]);
    }

    // Funcionalidades

    public function crear(Request $request,int $materia_id){
        $validate = $this->validate($request,[
            'fecha'             =>  ['required','string'],
            'presencialidad'    =>  ['required','alpha']
        ]);

        $asistencia = new Asistencia();
        $asistencia->materia_id = (int) $materia_id;
        $asistencia->fecha = $request->input('fecha');
        $asistencia->presencialidad = $request->input('presencialidad');

        $asistencia->save();

        return redirect()->route('asis.crear',[
            'id'    =>  $asistencia->id  
        ]);
    }

    public function cerrar_planilla(int $id){
        $procesos = Proceso::where('materia_id',$id)->get();
        $asistencias = Asistencia::where([
            'materia_id'    =>  $id
        ])->get();

        foreach ($procesos as $proceso){

            $presentes = 0;
            $total = 0;
            
            foreach($asistencias as $dia){
                foreach($dia->asistencias as $asistencia){
                    if($asistencia->alumno_id == $proceso->alumno_id){
                        $total++;
                        if($asistencia->estado == 'presente'){
                            $presentes++;
                        }
                    }
                }
            }
            $porcentaje = ($presentes * 100) / $total;

            $proceso->final_asistencia = round($porcentaje,2);

            if($proceso->final_parciales && $proceso->final_trabajos && $proceso->final_asistencia){
                if($proceso->final_parciales > 6 && $proceso->final_trabajos >= 6 && $porcentaje >= 70){
                    $proceso->estado = 'regular';
                }else{
                    $proceso->estado = 'irregular';
                }
            }
            $proceso->update();
        }

        return redirect()->route('asis.cerrar',[
           'id' =>  $id
        ]);
    }
}
