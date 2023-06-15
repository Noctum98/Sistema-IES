<?php

namespace App\Http\Controllers\Trianual;

use App\Http\Requests\Trianual\StoreTrianualRequest;
use App\Http\Requests\Trianual\UpdateTrianualRequest;
use App\Models\Alumno;
use App\Models\Estados;
use App\Models\Proceso;
use App\Models\Sede;
use App\Models\Trianual\Trianual;
use App\Services\AlumnoService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TrianualController extends Controller
{
    /**
     * @var AlumnoService
     */
    private $alumnoService;

    /**
     * @param AlumnoService $alumnoService
     */
    public function __construct(AlumnoService $alumnoService)
    {
        $this->alumnoService = $alumnoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $trianual = null;
        $alumnos = null;
        $busqueda = $request->get('busqueda');
        if (isset($request['busqueda']) && $request['busqueda'] != '') {
            $alumnos = $this->alumnoService->buscarAlumnos($request);
            $busqueda = $request['busqueda'] ?? true;

            if($alumnos) {
                $trianual = Trianual::whereIn(
                    'alumno_id', $alumnos->pluck('id')
                )
                    ->get();
            }
        }


        return view('trianual.trianual.index', [
            'trianual' => $trianual,
            'sedes' => Sede::all(),
            'busqueda' => $busqueda,
            'alumnos' => $alumnos,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse
     */
    public function create(Alumno $idAlumno)
    {
//        'sede_id',
//        'carrera_id',
//        'cohorte',
//        'resolucion',
//        'alumno_id',
//        'matricula',
//        'libro',
//        'folio',
//        'operador_id',
//        'promedio',
//        'fecha_egreso',
//        'preceptor',
//        'coordinator'

        $alumno = $idAlumno->first();

        dd($alumno->alumno_carrera()->first()->carrera());



//        $procesos = Proceso::where([
//            'ciclo_lectivo' => $ciclo_lectivo,
//            'alumno_id' => $alumnoId
//        ])
//            ->get();
//
//        $estados = Estados::all();

        return view('regularidad.components.form_agregar_regularidad')->with([
            'estados' => $estados,
            'procesos' => $procesos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Trianual\StoreTrianualRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrianualRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Trianual $trianual
     * @return \Illuminate\Http\Response
     */
    public function show(Trianual $trianual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Trianual $trianual
     * @return \Illuminate\Http\Response
     */
    public function edit(Trianual $trianual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Trianual\UpdateTrianualRequest $request
     * @param \App\Models\Trianual $trianual
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrianualRequest $request, Trianual $trianual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Trianual $trianual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trianual $trianual)
    {
        //
    }
}
