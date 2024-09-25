<?php

namespace App\Http\Controllers;

use App\Mail\BajaMesaMotivos;
use App\Models\Instancia;
use App\Models\Sede;
use App\Models\MesaAlumno;
use App\Models\Mesa;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Mail\MesaEnrolled;
use App\Mail\MesaUnsubscribe;
use App\Models\ActaVolante;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Materia;
use App\Models\Parameters\CicloLectivo;
use App\Models\Proceso;
use App\Services\Mesas\InstanciaService;
use App\Services\Mesas\MesaAlumnoService;
use App\Services\MesaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AlumnoMesaController extends Controller
{
    protected $mesaService;
    protected $mesaAlumnoService;
    protected $instanciaService;

    public function __construct(
        MesaService $mesaService,
        MesaAlumnoService $mesaAlumnoService,
        InstanciaService $instanciaService
    ) {
        $this->middleware('app.auth');
        $this->mesaService = $mesaService;
        $this->mesaAlumnoService = $mesaAlumnoService;
        $this->instanciaService = $instanciaService;
    }
    // Vistas
    public function vista_home($id)
    {
        $instancia = Instancia::find($id);
        $sedes = Sede::all();

        if (!$instancia) {
            return view('error.error');
        } elseif ($instancia->estado == 'inactiva') {
            return view('error.mesa_closed');
        } else {
            session(['instancia' => $instancia]);
            return view('mesa.welcome', [
                'instancia' => $instancia,
                'sedes'     =>  $sedes
            ]);
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function vista_instancias()
    {
        // Fecha actual y fecha límite de hace 2 meses
        $fechaActual = Carbon::now()->format('Y-m-d'); // Formateamos como Y-m-d
        $dosMesesAntes = Carbon::now()->subMonths(2)->format('Y-m-d'); // Fecha de hace 2 meses también en Y-m-d


        // Ajustamos la consulta
        $instanciasV = Instancia::whereDate('fecha_habilitacion', '<=', $fechaActual) // Fecha habilitación <= actual
            ->whereDate('fecha_habilitacion', '>=', $dosMesesAntes) // Fecha habilitación >= hace 2 meses
            ->get();
        foreach ($instanciasV as $instancia) {
            $this->instanciaService->verifyCierres($instancia);
        }
        $alumno = Auth::user() ? Auth::user()->alumno() : session('alumno');
        $inscripciones = MesaAlumno::where([
            'dni' => $alumno->dni,
        ])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $instancias = Instancia::where('estado', 'activa')->get();

        return view('mesa.instancias', [
            'instancias' => $instancias,
            'inscripciones' => $inscripciones
        ]);
    }

    public function vista_materias($instancia_id = null)
    {
        $alumno = Auth::user() ? Auth::user()->alumno() : session('alumno');
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');
        $lastCicloLectivo = CicloLectivo::orderBy('created_at', 'desc')->first();
        $alumnoCarreras = AlumnoCarrera::where(['alumno_id' => $alumno->id, 'ciclo_lectivo' => $lastCicloLectivo->year])->get();
        $carreras = [];

        $instancia = $this->instanciaService->verifyCierres($instancia);

        foreach ($alumnoCarreras as $inscripcionCarrera) {
            $carreras[] = $inscripcionCarrera->carrera;
        }

        if ($instancia->cierre) {
            $carreras = null;
        }

        if ($instancia->estado == 'inactiva') {
            return view('error.mesa_closed');
        } else {

            if ($instancia->tipo == 0) {
                $inscripciones = MesaAlumno::where([
                    'dni' => $alumno['dni'],
                ])->whereHas('mesa', function ($query) use ($instancia) {
                    return $query->where('instancia_id', $instancia->id);
                })->get();
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

    public function vista_inscriptos($materia_id, $instancia_id)
    {
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');
        $materia = Materia::find($materia_id);
        $mesa = null;

        $inscripciones = $this->mesaAlumnoService->obtenerInscripciones($instancia->id, $materia_id, 0);
        $inscripciones_baja = $this->mesaAlumnoService->obtenerInscripciones($instancia->id, $materia_id, 1);

        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->join('alumno_carrera', 'alumno_carrera.id', 'procesos.inscripcion_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('alumno_carrera.aprobado', 1)->orderBy('alumnos.apellidos')->get();

        $verificacion = $this->mesaService->verificarInscripcionesEspeciales($inscripciones, $materia, $instancia);

        $data = [
            'inscripciones' => $inscripciones,
            'inscripciones_baja' => $inscripciones_baja,
            'materia' => $materia,
            'instancia' => $instancia,
            'procesos' => $procesos,
            'mesa' => $verificacion['mesa'],
            'comisiones' => $verificacion['comisiones']
        ];

        if ($verificacion['mesa']) {
            $cierres = [
                'cierre_primer_llamado' => false,
                'cierre_segundo_llamado' => false
            ];

            $data = array_merge($cierres, $data);
        }
        return view('mesa.inscripciones_especial', $data);
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

    // Funcionalidad
    public function inscripcion(Request $request, $instancia_id = null)
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
            $mesas_alumnos = MesaAlumno::where([
                'dni' => $alumno['dni'],
            ])->whereHas('mesa', function ($query) use ($instancia) {
                return $query->where('instancia_id', $instancia->id);
            })->get();
        }

        if ((count($mesas_alumnos) + count($datos) - 1) > $instancia->limite) {
            return redirect()->route('mesa.mate', [
                'instancia_id' => $instancia->id
            ])->with([
                'error_mesa' => 'Solo te puedes inscribir a ' . $instancia->limite . ' materias.'
            ]);
        } else {
            unset($datos['_token']);
            foreach ($datos as $dato) {

                if ($instancia->tipo == 0) {
                    $mesa = Mesa::find($dato);
                    $materia = $mesa->materia;
                } else {
                    $materia = Materia::find($dato);
                }
                $inscripcionCarrera = $alumno->lastProcesoCarrera($materia->carrera_id);


                foreach ($mesas_alumnos as $inscripcion) {
                    if ($instancia->tipo == 1) {

                        if ($inscripcion->materia_id == $dato && !$inscripcion->estado_baja) {
                            return redirect()->route('mesa.mate', [
                                'instancia_id' => $instancia->id
                            ])->with([
                                'error_materia' => 'No puedes inscribirte 2 veces a la misma materia'
                            ]);
                        }
                    }
                }

                $inscripcion = new MesaAlumno();
                $inscripcion->alumno_id = Auth::user() ? Auth::user()->alumno()->id : null;
                $inscripcion->nombres = $alumno['nombres'];
                $inscripcion->apellidos = $alumno['apellidos'];
                $inscripcion->dni = $alumno['dni'];
                $inscripcion->correo = $alumno['email'] ? $alumno['email'] : $alumno['correo'];
                $inscripcion->telefono = $alumno['telefono'];
                $inscripcion->inscripcion_id = $inscripcionCarrera->id;
                if ($instancia->tipo == 0) {
                    if (time() > strtotime($mesa->fecha) || isset($request['segundo-' . $mesa->id])) {
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

            Mail::to($inscripcion->correo)->queue(new MesaEnrolled($datos, $instancia, $inscripcion));

            return redirect()->route('mesa.mate', [
                'instancia_id' => $instancia->id
            ])->with([
                'inscripcion_success' => $mensaje
            ]);
        }
    }

    // Función para coordinadores
    public function inscribir_alumno(Request $request)
    {
        $alumno = Alumno::find($request['alumno_id']);


        if ($request['mesa_id'] && $request['mesa_id'] != null) {
            $mesa = Mesa::find($request['mesa_id']);
            $inscripcion = MesaAlumno::where([
                'alumno_id' => $request['alumno_id'],
                'mesa_id' => $request['mesa_id'],
                'segundo_llamado' => $request['llamado']
            ])->first();
            $materia = $mesa->materia;
        } else {
            $inscripcion = MesaAlumno::where([
                'alumno_id' => $request['alumno_id'],
                'instancia_id' => $request['instancia_id'],
                'materia_id' => $request['materia_id']
            ])->first();

            $materia = Materia::find($request['materia_id']);
        }
        $inscripcion_id = $alumno->lastProcesoCarrera($materia->carrera_id);

        if (!$inscripcion_id) {
            $mensaje = ['alert_danger' => 'El alumno no está inscripto a la carrera.'];
        } else {
            if (!$inscripcion) {
                $request['nombres'] = $alumno->nombres;
                $request['apellidos'] = $alumno->apellidos;
                $request['dni'] = $alumno->dni;
                $request['correo'] = $alumno->email;
                $request['telefono'] = $alumno->telefono;
                $request['segundo_llamado'] = $request['llamado'];
                $request['inscripcion_id'] = $inscripcion_id->id;
                $inscripcion = MesaAlumno::create($request->all());

                $mensaje = ['alert_success' => 'El alumno ha sido inscripto.'];
            } else {
                $mensaje = ['alert_danger' => 'El alumno ya esta inscripto a este llamado.'];
            }
        }


        return redirect()->back()->with($mensaje);
    }

    public function bajar_mesa($id, $instancia_id = null)
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
                    $inscripcion->estado_baja = true;

                    Mail::to($inscripcion->correo)->send(new MesaUnsubscribe($inscripcion, $instancia));
                }
            } else {
                if (time() > $inscripcion->mesa->cierre) {
                    return redirect()->route('mesa.mate')->with([
                        'error_baja' => 'Ya ha pasado el tiempo límite para bajarte de esta mesa'
                    ]);
                } else {
                    $inscripcion->estado_baja = true;
                    Mail::to($inscripcion->correo)->send(new MesaUnsubscribe($inscripcion, $instancia));
                }
            }
        } else {
            $inscripcion->estado_baja = true;
            Mail::to($inscripcion->correo)->send(new MesaUnsubscribe($inscripcion, $instancia));
        }
        if (Auth::user()) {
            $inscripcion->user_id = Auth::user()->id;
        }
        $inscripcion->motivo_baja = 'Baja del alumno';
        $inscripcion->update();

        ActaVolante::where('mesa_alumno_id', $inscripcion->id)->delete();

        return redirect()->back();
    }

    public function alta_mesa(Request $request, $id)
    {
        $inscripcion = MesaAlumno::find($id);

        $inscripcion->estado_baja = false;
        $inscripcion->confirmado = false;
        $inscripcion->user_id = null;
        $inscripcion->motivo_baja = null;
        $inscripcion->update();

        return redirect()->back();
    }

    public function borrar_inscripcion(Request $request, $id, $instancia_id = null)
    {
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');
        $inscripcion = MesaAlumno::find($id);
        $mesa_id = $inscripcion->mesa_id;

        $inscripcion->user_id = Auth::user()->id;

        if ($instancia->tipo == 1) {
            if ($request['motivos']) {
                foreach ($request['motivos'] as $motivo) {
                    $inscripcion->motivo_baja = $inscripcion->motivo_baja . ' | ' . $motivo;
                }
            } else {
                $request['motivos'] = "Baja realizada por el alumno.";
            }


            $inscripcion->estado_baja = true;
            $inscripcion->update();
            Mail::to($inscripcion->correo)->send(new BajaMesaMotivos($request['motivos'], $instancia, $inscripcion));

            $ruta = 'mesa.especial.inscriptos';
            $id = $inscripcion->materia_id;
        }

        if ($instancia->tipo == 0) {
            if ($request['motivos']) {
                foreach ($request['motivos'] as $motivo) {
                    $inscripcion->motivo_baja = $inscripcion->motivo_baja . ' | ' . $motivo;
                }
            } else {
                $request['motivos'] = "Baja realizada por el alumno.";
                $inscripcion->motivo_baja = $request['motivos'];
            }
            $inscripcion->estado_baja = true;
            $inscripcion->update();
            Mail::to($inscripcion->correo)->send(new BajaMesaMotivos($request['motivos'], $instancia, $inscripcion));

            $ruta = 'mesa.inscriptos';
            $id = $inscripcion->materia_id;
        }

        ActaVolante::where('mesa_alumno_id', $inscripcion->id)->delete();

        return redirect()->back()->with([
            'alert_warning' => 'Se ha dado de baja la inscripción correctamente'
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
            $inscripciones = MesaAlumno::where([
                'dni' => $dni,
            ])->whereHas('mesa', function ($query) use ($instancia) {
                return $query->where('instancia_id', $instancia->id);
            })->get();
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

    public function confirmar(Request $request, $id)
    {
        $inscripcion = MesaAlumno::find($id);

        $inscripcion->confirmado = true;

        $inscripcion->update();

        $data = [
            'status' => 'success',
            'inscripcion' => $inscripcion
        ];

        return response()->json($data, 200);
    }

    public function moverComision(Request $request, $inscripcion_id)
    {
        $mesaActual = Mesa::find($request['mesa_id']);
        $inscripcion = MesaAlumno::find($inscripcion_id);

        $mesaNueva = Mesa::where([
            'instancia_id' => $mesaActual->instancia_id,
            'materia_id' => $mesaActual->materia_id,
            'comision_id' => $request['comision_id']
        ])->first();

        if ($mesaNueva) {
            $inscripcion->mesa_id = $mesaNueva->id;
            $mensaje = ['alert_success' => 'Se ha movido correctamente la inscripción de comisión.'];
        } else {
            $mensaje = ['alert_danger' => 'No se ha creado una mesa para la comisión seleccionada'];
        }

        $inscripcion->update();

        return redirect()->back()->with($mensaje);
    }

    public function asignar_mesa(Request $request)
    {
        $mesa_id = $request['mesa_id'];
        $inscripcion_id = $request['inscripcion_id'];

        $inscripcion = MesaAlumno::find($inscripcion_id);

        $inscripcion->mesa_id = $mesa_id;
        $inscripcion->segundo_llamado = false;
        $inscripcion->update();

        return redirect()->back()->with(['alert_success', 'Mesa asignada correctamente.']);
    }

    /**
     * @param $mesa_alumno_id
     * @param $materia_id
     * @return JsonResponse
     */
    public function verificarInscripcion($mesa_alumno_id, $materia_id): JsonResponse
    {
        $datos = $this->mesaAlumnoService->condicionesRendir($mesa_alumno_id, $materia_id);

        return response()->json($datos, 200);
    }

    // Funciones privadas
    private function comprobacionInscripcion($mesas_alumnos, $instancia, $dato)
    {
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
