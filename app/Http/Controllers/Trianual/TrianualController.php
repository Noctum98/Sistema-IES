<?php

namespace App\Http\Controllers\Trianual;

use App\Http\Requests\Trianual\StoreTrianualRequest;
use App\Http\Requests\Trianual\UpdateTrianualRequest;
use App\Models\Alumno;
use App\Models\Estados;
use App\Models\Proceso;
use App\Models\Sede;
use App\Models\Trianual\Trianual;
use App\Models\User;
use App\Services\AlumnoService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TrianualController extends Controller
{

    const CAMPOS_TRIANUAL = [
        'carrera',
        'cohorte',
        'resolucion',
        'alumno_id',
        'matricula',
        'libro',
        'folio',
        'operador_id',
        'promedio',
        'fecha_egreso',
        'preceptor',
        'coordinator'
    ];
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

            if ($alumnos) {
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
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(Request $request)
    {
        $alumno = Alumno::find($request->get('alumno'));
        if (!$alumno) {
            return view('trianual.trianual.index', [
                'trianual' => false,
                'sedes' => Sede::all(),
                'busqueda' => false,
                'alumnos' => false,

            ]);
        }

        $campos = self::CAMPOS_TRIANUAL;
        $datos = [];

        $carrera = $alumno->alumno_carrera()->first()->carrera()->id;
        if ($carrera) {
            unset($campos[0]);
            $datos['carrera'] = $alumno->alumno_carrera()->first()->carrera()->nombre;
        }
        if ($alumno->cohorte) {
            unset($campos[1]);
            unset($campos[3]);
            $datos['cohorte'] = $alumno->cohorte;
        }


//        $procesos = Proceso::where([
//            'ciclo_lectivo' => $ciclo_lectivo,
//            'alumno_id' => $alumnoId
//        ])
//            ->get();
//
//        $estados = Estados::all();
        $coordinadores = User::whereHas('roles', function ($query) {
            return $query->where('nombre', 'coordinador');
        })->get();
        $bedeles = User::whereHas('roles', function ($query) {
            return $query->where('nombre', 'seccionAlumnos');
        })->get();

        return view('trianual.trianual.components.form_agregar_trianual')->with([
            'campos' => $campos,
            'alumno' => $alumno,
            'coordinadores' => $coordinadores,
            'bedeles' => $bedeles,
            'datos' => $datos
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
