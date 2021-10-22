<?php

namespace App\Http\Controllers;

use App\Models\Instancia;
use App\Models\Sede;
use App\Models\Carrera;
use App\Models\MesaAlumno;
use Illuminate\Http\Request;
use App\Mail\MesaEnrolled;
use App\Mail\MesaUnsubscribe;
use Illuminate\Support\Facades\Mail;

class AlumnoMesaController extends Controller
{
    public function __construct(){

    }
    // Vistas
    public function vista_home($id){
        $instancia = Instancia::find($id);
        $sedes = Sede::all();
        
        if($instancia->estado == 'inactiva'){
            return view('error.mesa_closed');
        }else{
            session(['instancia'=>$instancia]);
            return view('mesa.welcome',[
                'instancia' => $instancia,
                'sedes'     =>  $sedes
            ]);
        }
    }
    public function vista_materias(){
        $alumno = session('alumno');
        $instancia = session('instancia');
        $carreras = Carrera::where('sede_id',$alumno['sede'])->get();
        
        if($instancia->estado == 'inactiva'){
            return view('error.mesa_closed');
        }else{

           if($instancia->tipo == 0){
                $insc = MesaAlumno::where([
                    'dni' => $alumno['dni'],
                ])->whereNotNull('mesa_id')->get();
                $inscripciones = [];
                foreach($insc as $inscripcion){
                    if($inscripcion->mesa->instancia_id == $instancia->id){
                        array_push($inscripciones,$inscripcion);
                    }
                }
           }else{
                $inscripciones = MesaAlumno::where([
                'dni' => $alumno['dni'],
                'instancia_id' => $instancia->id
                ])->get();
           }
           
            return view('mesa.materias',[
                'carreras'  =>  $carreras,
                'inscripciones' => $inscripciones,
                'instancia' => $instancia
            ]);
        }
    }
    public function materias(Request $request){
        $validate = $this->validate($request,[
            'nombres'   => ['required','string'],
            'apellidos' => ['required','string'],
            'dni'       => ['required','numeric','digits:8'],
            'email'     => ['required','email'],
            'telefono'  => ['required']
        ]);
        $datos = $request->all();
        session(['alumno'=>$datos]);
    
        

        return redirect()->route('mesa.mate');
    }

    // Funcionalidade
    public function inscripcion(Request $request){
        $alumno = session('alumno');
        $instancia = session('instancia');
        $datos = $request->all();

        if($instancia->tipo == 1){
            $mesas_alumnos = MesaAlumno::where([
                'dni' => $alumno['dni'],
                'instancia_id' => $instancia->id
            ])->get();
        }else{
            $insc = MesaAlumno::where([
                'dni' => $alumno['dni'],
            ])->whereNotNull('mesa_id')->get();
            $mesas_alumnos = [];
            foreach($insc as $inscripcion){
                if($inscripcion->mesa->instancia_id == $instancia->id){
                    array_push($mesas_alumnos,$inscripcion);
                }
            }
        }
        if((count($mesas_alumnos) + count($datos) - 1) > $instancia->limite){
             return redirect()->route('mesa.mate')->with([
                'error_mesa' => 'Solo te puedes inscribir a '.$instancia->limite.' materias.'
             ]);
        }else{
            unset($datos['_token']);
            foreach($datos as $dato){
                foreach($mesas_alumnos as $inscripcion){
                    if($instancia->tipo == 1){
                        if($inscripcion->materia_id == $dato){
                            return redirect()->route('mesa.mate')->with([
                                'error_materia' => 'No puedes inscribirte 2 veces a la misma materia'
                            ]);
                        }
                    }else{
                        if($inscripcion['mesa_id'] == $dato){
                            return redirect()->route('mesa.mate')->with([
                                'error_materia' => 'No puedes inscribirte 2 veces a la misma materia'
                            ]);
                        }
                    }
                }
                $inscripcion = new MesaAlumno();
                $inscripcion->nombres = $alumno['nombres'];
                $inscripcion->apellidos = $alumno['apellidos'];
                $inscripcion->dni = $alumno['dni'];
                $inscripcion->correo = $alumno['email'] ? $alumno['email'] : $alumno['correo'];
                $inscripcion->telefono = $alumno['telefono'];
                if($instancia->tipo == 0){
                    $inscripcion->mesa_id = (int) $dato;
                }else{
                    $inscripcion->materia_id = (int) $dato;
                    $inscripcion->instancia_id = $instancia->id; 
                }
                $inscripcion->save();
            }
            Mail::to($inscripcion->correo)->send(new MesaEnrolled($datos,$instancia,$alumno));
            return redirect()->route('mesa.mate')->with([
                'inscripcion_success'=>'Ya estas inscripto correctamente y se ha enviado un comprobante a tu correo electrónico.'
            ]);
        }   
    }

    public function bajar_mesa($id){
        $inscripcion = MesaAlumno::find($id);
        Mail::to($inscripcion->correo)->send(new MesaUnsubscribe($inscripcion));
        $inscripcion->delete();

       return redirect()->route('mesa.mate');
    }
    public function email_session($dni,$instancia_id,$sede_id){
        $inscripciones = MesaAlumno::where([
            'dni' => $dni,
            'instancia_id' => $instancia_id
        ])->get();
        
        if(count($inscripciones) == 0){
            return redirect()->route('mesa.welcome',[
                'id'=>$instancia_id
            ]);
        }else{
            $instancia = Instancia::find($instancia_id);

            $inscripcion = $inscripciones->all();
            $datos = $inscripcion[0];
            $datos['sede'] = $sede_id;
    
            $instancia = session([
                'instancia' => $instancia,
                'alumno'    => $datos
            ]);
            return redirect()->route('mesa.mate');
        }

    }
}
