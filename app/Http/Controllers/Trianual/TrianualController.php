<?php

namespace App\Http\Controllers\Trianual;

use App\Http\Requests\Trianual\StoreTrianualRequest;
use App\Http\Requests\Trianual\UpdateTrianualRequest;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Carrera;
use App\Models\Estados;
use App\Models\Proceso;
use App\Models\Sede;
use App\Models\Trianual\Trianual;
use App\Models\User;
use App\Repository\Alumno\AlumnoRepository;
use App\Services\AlumnoService;
use App\Services\CarreraService;
use App\Services\Trianual\DetalleTrianualService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use stdClass;

class TrianualController extends Controller
{

    const CAMPOS_TRIANUAL = [
        'carrera',
        'cohorte',
        'matricula',
        'resolucion',
        'alumno_id',
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
     * @var CarreraService
     */
    private $carreraService;
    /**
     * @var DetalleTrianualService
     */
    private $detalleTrianualService;

    /**
     * @param AlumnoService $alumnoService
     * @param CarreraService $carreraService
     * @param DetalleTrianualService $detalleTrianualService
     */
    public function __construct(AlumnoService $alumnoService, CarreraService $carreraService, DetalleTrianualService $detalleTrianualService)
    {
        $this->alumnoService = $alumnoService;
        $this->carreraService = $carreraService;
        $this->detalleTrianualService = $detalleTrianualService;
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
    public function create(Request $request, int $alumno)
    {

        // Tengo que agregar la opción de buscar por carrera antes de crear el trianual
        $alumno = Alumno::find($alumno);
        $sedes = Sede::all();

        $alumnoRepository = new AlumnoRepository();
        $carreras = $alumnoRepository->getCarrerasByAlumno($alumno->id);


        if (!$alumno) {
            return view('trianual.trianual.index', [
                'trianual' => false,
                'sedes' => $sedes,
                'busqueda' => false,
                'alumnos' => false,
            ]);
        }

        $campos = self::CAMPOS_TRIANUAL;
        $datos = [];


        if (count($carreras) == 1) {
            unset($campos[0]);
            $datos['carrera'] = $alumno->alumno_carrera()->first()->carrera->nombre;
        }


        if ($alumno->cohorte) {
            unset($campos[1]);
            $datos['cohorte'] = $alumno->cohorte;
        }

        if (count($carreras) > 0) {
            $sedes = $alumnoRepository->getSedesByAlumno($alumno->id);
        }

        $datos['alumno_id'] = $alumno->id;
        unset($campos[7]);
        unset($campos[3]);

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
            'datos' => $datos,
            'sedes' => $sedes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTrianualRequest $request
     * @return Application|Factory|View
     */
    public function store(StoreTrianualRequest $request)
    {

        $datos = [];

        $alumno = Alumno::find($request->get('alumno'));
        $sedes = Sede::all();

        if (!$alumno) {
            return view('trianual.trianual.index', [
                'trianual' => false,
                'sedes' => $sedes,
                'busqueda' => false,
                'alumnos' => false,
            ]);
        }

        $trianual = Trianual::where(
            'alumno_id', $alumno->id
        )
            ->first();

        if ($trianual) {
            return view('trianual.trianual.index', [
                'trianual' => $trianual,
                'sedes' => Sede::all(),
                'busqueda' => $alumno->dni,
                'alumnos' => [$alumno],

            ]);
        }
//        $carrera = $alumno->alumno_carrera()->first()->carrera();


        $carrera = $this->carreraService->getCarrera($request->get('carrera_id'));
        if (!$carrera) {
            $carrera = $this->carreraService->getCarrera($request->get('carrera'));
        }
        if ($request->get('cohorte')) {
            $alumno->cohorte = $request->get('cohorte');
            $alumno->update();
        }

        $datos['carrera_id'] = $carrera->id;
        $datos['cohorte'] = $alumno->cohorte ?? $request->get('cohorte');
        $datos['matricula'] = $request->get('matricula');
        $datos['resolucion'] = $request->get('resolucion');
        $datos['alumno_id'] = $alumno->id;
        $datos['libro'] = $request->get('resolucion');
        $datos['folio'] = $request->get('folio');
        $datos['operador_id'] = Auth::user()->id;
        $datos['promedio'] = $request->get('promedio');
        $datos['fecha_egreso'] = $request->get('fecha_egreso');
        $datos['preceptor_id'] = $request->get('preceptor');
        $datos['coordinator_id'] = $request->get('coordinator');
        $datos['sede_id'] = $carrera->sede_id;
        $trianual = Trianual::create($datos);

//        return view('trianual.detalle.detail', [
//            'trianual' => $trianual,
//            'alumno' => $alumno,
//
//        ]);
        $estados = Estados::all();
        $detalles = $this->detalleTrianualService->detallesPorTrianual($trianual->id);
        return view('trianual.trianual.show', [
            'trianual' => $trianual,
            'estados' => $estados,
            'detalles' => $detalles
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param Trianual $trianual
     * @return Application|Factory|View
     */
    public function show(Trianual $trianual)
    {
        $estados = Estados::all();

        $detalles = $this->detalleTrianualService->detallesPorTrianual($trianual->id);


        return view('trianual.trianual.show', [
            'trianual' => $trianual,
            'estados' => $estados,
            'detalles' => $detalles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Trianual $trianual
     * @return Response
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
     * @return Response
     */
    public function update(UpdateTrianualRequest $request, Trianual $trianual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Trianual $trianual
     * @return Response
     */
    public function destroy(Trianual $trianual)
    {
        //
    }


}
