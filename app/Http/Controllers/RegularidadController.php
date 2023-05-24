<?php

namespace App\Http\Controllers;

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
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(RegularidadesRequest $request)
    {

        $request->validated();
        $user = Auth::user();

        $regularidad = Regularidad::create([
            'estado_id' => $request->get('estado_id'),
            'proceso_id' => $request->get('proceso_id'),
            'operador_id' => $user->id,
            'observaciones' => $request->get('observaciones'),
            'fecha_regularidad' => $request->get('fecha_regularidad'),
            'fecha_vencimiento' => date('d F Y', strtotime($request->get('fecha_regularidad') . " +2 year") ),
        ]
        );

        dd($regularidad);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Regularidad $regularidad
     * @return Response
     */
    public function show(Regularidad $regularidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Regularidad $regularidad
     * @return Response
     */
    public function edit(Regularidad $regularidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Regularidad $regularidad
     * @return Response
     */
    public function update(Request $request, Regularidad $regularidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Regularidad $regularidad
     * @return Response
     */
    public function destroy(Regularidad $regularidad)
    {
        //
    }
}
