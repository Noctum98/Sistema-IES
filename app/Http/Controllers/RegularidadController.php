<?php

namespace App\Http\Controllers;

use App\Helper\helper;
use App\Models\Estados;
use App\Models\Proceso;
use App\Models\Regularidad;
use App\Request\RegularidadesRequest;
use App\Services\AlumnoService;
use App\Services\CicloLectivoService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegularidadController extends Controller
{
    use helper;
    /**
     * @var AlumnoService
     */
    private $alumnoService;
    /**
     * @var CicloLectivoService
     */
    private $cicloLectivoService;

    /**
     * @param AlumnoService $alumnoService
     * @param CicloLectivoService $cicloLectivoService
     */
    function __construct(AlumnoService $alumnoService, CicloLectivoService $cicloLectivoService)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-equivalencias');

        $this->alumnoService = $alumnoService;
        $this->cicloLectivoService = $cicloLectivoService;
    }


    /**
     * Muestra la pantalla de búsqueda de alumnos para cargar regularidad.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $alumnos = [];
        $busqueda = null;

        if (isset($request['busqueda']) && $request['busqueda'] != '') {
            $alumnos = $this->alumnoService->buscarAlumnos($request);
            $busqueda = $request['busqueda'] ?? true;
        }
//        dd($request['busqueda']);

        $ciclo_lectivo = $request['ciclo_lectivo'] ?? date('Y');


//        list($last, $ahora) = $this->cicloLectivoService->getCicloInicialYActual();


        //dd($alumnos);
        $data = [
            'alumnos' => $alumnos,
            'busqueda' => $busqueda,
            'carrera_id' => $request['carrera_id'],
            'materia_id' => $request['materia_id'],
            'cohorte' => $request['cohorte'],
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            'ciclo_lectivo' => $ciclo_lectivo
        ];

        return view('regularidad.index', $data);
    }

    /**
     * Muestra la pantalla de búsqueda de alumnos para cargar regularidad de ciclos lectivos anteriores.
     *
     * @param Request $request
     * @return Response
     */
    public function anteriores(Request $request)
    {
        $user = $this->userActual();
        $alumnos = [];
        $busqueda = null;

        if (isset($request['busqueda']) && $request['busqueda'] != '') {
            $alumnos = $this->alumnoService->buscarAlumnos($request);
            $busqueda = $request['busqueda'] ?? true;
        }
//        dd($request['busqueda']);

        $ciclo_lectivo = $request['ciclo_lectivo'] ?? date('Y');


//        list($last, $ahora) = $this->cicloLectivoService->getCicloInicialYActual();


        //dd($alumnos);
        $data = [
            'alumnos' => $alumnos,
            'busqueda' => $busqueda,
            'carrera_id' => $request['carrera_id'],
            'materia_id' => $request['materia_id'],
            'cohorte' => $request['cohorte'],
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            'ciclo_lectivo' => $ciclo_lectivo
        ];

        return view('regularidad.anteriores', $data);
    }

    /**
     * Mostramos un modal para agregar una regularidad a un alumno.
     *
     * @param int $alumnoId
     * @param int $ciclo_lectivo
     * @return Application|Factory|View
     */
    public function create(int $alumnoId, int $ciclo_lectivo)
    {
        $procesos = Proceso::where([
            'ciclo_lectivo' => $ciclo_lectivo,
            'alumno_id' => $alumnoId
        ])
            ->get();

        $estados = Estados::all();

        return view('regularidad.components.form_agregar_regularidad')->with([
            'estados' => $estados,
            'procesos' => $procesos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegularidadesRequest $request
     * @return Response
     */
    public function store(RegularidadesRequest $request)
    {

        $request->validated();
        $user = Auth::user();

        $regularidad = Regularidad::where([
            'proceso_id' => $request->get('proceso_id')
        ])->first();
        if ($regularidad) {
            $mensaje = "Ya existe regularidad cargada para {$regularidad->obtenerAlumno()->getApellidosNombresAttribute()} en la materia {$regularidad->obtenerMateria()->nombre}";
        } else {
            $regularidad = Regularidad::create([
                    'estado_id' => $request->get('estado_id'),
                    'proceso_id' => $request->get('proceso_id'),
                    'operador_id' => $user->id,
                    'observaciones' => $request->get('observaciones'),
                    'fecha_regularidad' => $request->get('fecha_regularidad'),
                    'fecha_vencimiento' => date('d F Y', strtotime($request->get('fecha_regularidad') . " +2 year")),
                ]
            );
            $mensaje = "Regularidad cargada para {$regularidad->obtenerAlumno()->getApellidosNombresAttribute()} en la materia {$regularidad->obtenerMateria()->nombre}";
        }

        if ($request->get('ciclo_anterior')) {
            $this->procesoAnterior($regularidad, $request->get('ciclo_anterior'));
        }

        $data = [
            'alumnos' => [$regularidad->obtenerAlumno()],
            'busqueda' => true,
            'carrera_id' => $regularidad->obtenerMateria()->carrera(),
            'materia_id' => $regularidad->obtenerMateria(),
//            'cohorte' => $request['cohorte'],
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            'ciclo_lectivo' => $regularidad->getCicloLectivo()
        ];

        return view('regularidad.index', $data)->withSuccess($mensaje);

    }

    /**
     * Display the specified resource.
     *
     * @param Regularidad $regularidad
     * @return Response
     */
    public function show(Regularidad $regularidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Regularidad $regularidad
     * @return Application|Factory|View
     */
    public function edit(Regularidad $regularidad)
    {

        $estados = Estados::all();


        return view('regularidad.components.form_editar_regularidad')->with([
            'estados' => $estados,
            'regularidad' => $regularidad,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Regularidad $regularidad
     * @return Response
     */
    public function update(RegularidadesRequest $request, Regularidad $regularidad)
    {
        $request->validated();
        $user = Auth::user();

        $regularidad->update($request->all());
        $mensaje = "Regularidad actualizada";

        $data = [
            'alumnos' => [$regularidad->obtenerAlumno()],
            'busqueda' => true,
            'carrera_id' => $regularidad->obtenerMateria()->carrera(),
            'materia_id' => $regularidad->obtenerMateria(),
//            'cohorte' => $request['cohorte'],
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            'ciclo_lectivo' => $regularidad->getCicloLectivo()
        ];

        return view('regularidad.index', $data)->withSuccess($mensaje);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Regularidad $regularidad
     * @return Response
     */
    public function destroy(Regularidad $regularidad)
    {
        //
    }

    private function procesoAnterior(Regularidad $regularidad, $ciclo_anterior)
    {


        $procesoAnterior = Proceso::where([
            'alumno_id' => $regularidad->obtenerAlumno()->id,
            'ciclo_lectivo' => $ciclo_anterior,
            'materia_id' => $regularidad->obtenerMateria()->id,
        ])->first();


        if (!$procesoAnterior) {
            $procesoAnterior = Proceso::create([
                'alumno_id' => $regularidad->obtenerAlumno()->id,
                'estado_id' => $regularidad->obtenerEstado()->id,
                'materia_id' => $regularidad->obtenerMateria()->id,
                'ciclo_lectivo' => $ciclo_anterior,
                'operador_id' => $regularidad->operador_id,
                'cierre' => 1
            ]);
        }
        if (!$procesoAnterior->obtenerRegularidad()) {
            Regularidad::create([
                    'estado_id' => $regularidad->obtenerEstado()->id,
                    'proceso_id' => $procesoAnterior->id,
                    'operador_id' => $regularidad->operador_id,
                    'observaciones' => $regularidad->observaciones . ' Por Traspaso de regularidad.',
                    'fecha_regularidad' => date('d F Y', strtotime($ciclo_anterior . '-12-31')),
                    'fecha_vencimiento' => date('d F Y', strtotime($ciclo_anterior . '-12-31' . " +2 year")),

                ]
            );
        }
    }
}
