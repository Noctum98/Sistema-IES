<?php

namespace App\Http\Controllers;

use App\Mail\BajaMesaMotivos;
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

class AlumnoMesaController extends Controller
{

    public function __construct()
    {
        //$this->middleware('app.auth');
    }
    // Vistas
    public function vista_home($id)
    {
        $instancia = Instancia::find($id);
        $sedes = Sede::all();

        if(!$instancia){
            return view('error.error');
        }elseif ($instancia->estado == 'inactiva') {
            return view('error.mesa_closed');
        } else {
            session(['instancia' => $instancia]);
            return view('mesa.welcome', [
                'instancia' => $instancia,
                'sedes'     =>  $sedes
            ]);
        }
    }

    public function vista_instancias()
    {
        $instancias = Instancia::where('estado','activa')->get();

        return view('mesa.instancias',[
            'instancias' => $instancias
        ]);
    }

    public function vista_materias($instancia_id = null)
    {
        $alumno = Auth::user() ? Auth::user()->alumno() : session('alumno');
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');
        $carreras = Auth::user() ? $alumno->carreras : Carrera::where('sede_id', $alumno['sede'])->get();

        if($instancia->cierre)
        {
            $carreras = null;
        }

        if ($instancia->estado == 'inactiva') {
            return view('error.mesa_closed');
        } else {

            if ($instancia->tipo == 0) {
                $insc = MesaAlumno::where([
                    'dni' => $alumno['dni'],
                ])->whereNotNull('mesa_id')->get();
                $inscripciones = [];

                foreach ($insc as $inscripcion) {

                    if ($inscripcion->mesa->instancia_id == $instancia->id) {
                        $inscripciones[] = $inscripcion;
                    }
                }
            } else {
                $inscripciones = MesaAlumno::where([
                    'dni' => $alumno['dni'],
                    'instancia_id' => $instancia->id
                ])->get();
            }

            return view('mesa.materias', [
                'carreras'  =>  $carreras,
                'inscripciones' => $inscripciones,
                'instancia' => $instancia
            ]);
        }
    }

    public function vista_inscriptos($materia_id,$instancia_id=null)
    {
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');

        $inscripciones = MesaAlumno::select('nombres','apellidos','id','dni','alumno_id','instancia_id')->where([
            'materia_id'=>$materia_id,
            'estado_baja' => 0
        ])->get();
        $inscripciones_baja = MesaAlumno::select('nombres','apellidos','id','dni','alumno_id','updated_at')->where([
            'materia_id'=>$materia_id,
            'estado_baja' => 1
        ])->get();

        //dd($inscripciones);
        $materia = Materia::select('nombre','id')->where('id',$materia_id)->first();
        return view('mesa.inscripciones_especial',[
            'inscripciones' => $inscripciones,
            'inscripciones_baja' => $inscripciones_baja,
            'materia' => $materia,
            'instancia' => $instancia
        ]);
    }

    public function materias(Request $request)
    {
        $validate = $this->validate($request, [
            'nombres'   => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'dni'       => ['required', 'numeric', 'digits:8'],
            'email'     => ['required', 'email'],
            'telefono'  => ['required']
        ]);
        $datos = $request->all();
        session(['alumno' => $datos]);



        return redirect()->route('mesa.mate');
    }

    // Funcionalidade
    public function inscripcion(Request $request,$instancia_id = null)
    {
        $alumno = Auth::user() ? Auth::user()->alumno() : session('alumno');
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');
        $datos = $request->all();

        if ($instancia->tipo == 1) {
            $mesas_alumnos = MesaAlumno::where([
                'dni' => $alumno['dni'],
                'instancia_id' => $instancia->id,
                'estado_baja' => false
            ])->get();
        } else {
            $insc = MesaAlumno::where([
                'dni' => $alumno['dni'],
            ])->whereNotNull('mesa_id')->get();

            $mesas_alumnos = [];
            foreach ($insc as $inscripcion) {
                if ($inscripcion->mesa->instancia_id == $instancia->id) {
                    $mesas_alumnos[] = $inscripcion;
                }
            }
        }

        if ((count($mesas_alumnos) + count($datos) - 1) > $instancia->limite) {
            return redirect()->route('mesa.mate',[
                'instancia_id' => $instancia->id
            ])->with([
                'error_mesa' => 'Solo te puedes inscribir a ' . $instancia->limite . ' materias.'
            ]);
        } else {
            unset($datos['_token']);
            foreach ($datos as $dato) {

                foreach ($mesas_alumnos as $inscripcion) {
                    if ($instancia->tipo == 1) {

                        if ($inscripcion->materia_id == $dato && !$inscripcion->estado_baja) {
                            return redirect()->route('mesa.mate',[
                                'instancia_id' => $instancia->id
                            ])->with([
                                'error_materia' => 'No puedes inscribirte 2 veces a la misma materia'
                            ]);
                        }
                    } else {
                        if ($inscripcion['mesa_id'] == $dato) {

                            $inscripcion->delete();

                        }
                    }
                }

                //dd("Legue aca");
                $inscripcion = new MesaAlumno();
                $inscripcion->alumno_id = Auth::user() ? Auth::user()->alumno()->id : null;
                $inscripcion->nombres = $alumno['nombres'];
                $inscripcion->apellidos = $alumno['apellidos'];
                $inscripcion->dni = $alumno['dni'];
                $inscripcion->correo = $alumno['email'] ? $alumno['email'] : $alumno['correo'];
                $inscripcion->telefono = $alumno['telefono'];
                if ($instancia->tipo == 0) {
                    $mesa = Mesa::find($dato);
                    if (time() > strtotime($mesa->fecha)) {
                        $inscripcion->segundo_llamado = true;
                    } else {
                        $inscripcion->segundo_llamado = false;
                    }
                    $inscripcion->mesa_id = (int) $dato;
                } else {
                    $inscripcion->materia_id = (int) $dato;
                    $inscripcion->instancia_id = $instancia->id;
                }
                $inscripcion->save();
            }
$mensaje = 'Ya estas inscripto correctamente a las carreras seleccionadas.';

            if(!Auth::user())
            {
                //dd($datos);
                Mail::to($inscripcion->correo)->queue(new MesaEnrolled($datos, $instancia,$inscripcion));
                $mensaje = 'Ya estas inscripto correctamente, se ha enviado un comprobante a tu correo electronico.';
            }
            return redirect()->route('mesa.mate',[
                'instancia_id' => $instancia->id
            ])->with([
                'inscripcion_success' => $mensaje
            ]);
        }
    }

    public function bajar_mesa($id,$instancia_id = null)
    {
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');
        $inscripcion = MesaAlumno::find($id);

        if ($instancia->tipo == 0) {
            if (time() > strtotime($inscripcion->mesa->fecha)) {
                if (time() > $inscripcion->mesa->cierre_segundo) {
                    return redirect()->route('mesa.mate')->with([
                        'error_baja' => 'Ya ha pasado el tiempo límite para bajarte de esta mesa'
                    ]);
                } else {
                    $inscripcion->delete();
                    Mail::to($inscripcion->correo)->send(new MesaUnsubscribe($inscripcion));
                }
            } else {
                if (time() > $inscripcion->mesa->cierre) {
                    return redirect()->route('mesa.mate')->with([
                        'error_baja' => 'Ya ha pasado el tiempo límite para bajarte de esta mesa'
                    ]);
                } else {
                    $inscripcion->delete();
                    Mail::to($inscripcion->correo)->send(new MesaUnsubscribe($inscripcion));
                }
            }
        }else{
            $inscripcion->estado_baja = true;
            $inscripcion->update();
        }

        return redirect()->route('mesa.mate',[
            'instancia_id' => $instancia->id
        ]);
    }

    public function borrar_inscripcion(Request $request,$id,$instancia_id){
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');
        $inscripcion = MesaAlumno::find($id);
        $mesa_id = $inscripcion->mesa_id;

        if(isset($request['motivos']) || $instancia->tipo == 1)
        {
            Mail::to($inscripcion->correo)->send(new BajaMesaMotivos($request['motivos'],$instancia,$inscripcion));
            $inscripcion->estado_baja = true;
            $inscripcion->update();
            $ruta = 'mesa.especial.inscriptos';
            $id = $inscripcion->materia_id;
        }

        if ($instancia->tipo == 0) {
            $inscripcion->delete();

        }

        return redirect()->route($ruta,[
            'id' => $id,

        ])->with([
            'baja_exitosa' => 'Se ha dado de baja la inscripción correctamente'
        ]);
    }

    public function email_session($dni, $instancia_id, $sede_id)
    {
        $instancia = Instancia::find($instancia_id);
        session(['instancia' => $instancia]);

        if ($instancia->tipo == 1) {
            $inscripciones = MesaAlumno::where([
                'dni' => $dni,
                'instancia_id' => $instancia->id
            ])->get();
        } else {
            $insc = MesaAlumno::where([
                'dni' => $dni,
            ])->whereNotNull('mesa_id')->get();
            $inscripciones = [];
            foreach ($insc as $inscripcion) {
                if ($inscripcion->mesa->instancia_id == $instancia->id) {
                    array_push($inscripciones, $inscripcion);
                }
            }
        }

        if (count($inscripciones) == 0) {
            return redirect()->route('mesa.welcome', [
                'id' => $instancia_id
            ]);
        } else {
            if ($instancia->tipo == 1) {
                $inscripcion = $inscripciones->all();
                $datos = $inscripcion[0];
            } else {
                $datos = $inscripciones[0];
            }

            $datos['sede'] = $sede_id;

            $instancia = session([
                'instancia' => $instancia,
                'alumno'    => $datos
            ]);
            return redirect()->route('mesa.mate');
        }
    }

    // Funciones privadas

    private function comprobacionInscripcion($mesas_alumnos, $instancia, $dato)
    {
        //dd($mesas_alumnos,$dato);
        foreach ($mesas_alumnos as $inscripcion) {
            if ($instancia->tipo == 1) {

                if ($inscripcion->materia_id == $dato && !$inscripcion->estado_baja) {
                    return redirect()->route('mesa.mate')->with([
                        'error_materia' => 'No puedes inscribirte 2 veces a la misma materia'
                    ]);
                }
            } else {
                if ($inscripcion['mesa_id'] == $dato) {

                    $inscripcion->delete();

                }
            }
        }
    }
}
