<?php

namespace App\Http\Controllers;

use App\Models\Regularidad;
use App\Services\AlumnoService;
use App\Services\CicloLectivoService;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $alumnos = [];
        $busqueda = null;

        if (isset($request['busqueda']) && $request['busqueda'] !='') {
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regularidad  $regularidad
     * @return \Illuminate\Http\Response
     */
    public function show(Regularidad $regularidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Regularidad  $regularidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Regularidad $regularidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Regularidad  $regularidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regularidad $regularidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Regularidad  $regularidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regularidad $regularidad)
    {
        //
    }
}
