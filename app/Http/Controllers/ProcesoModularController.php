<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\AsistenciaModular;
use App\Models\Cargo;
use App\Models\CargoProceso;
use App\Models\Estados;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesoModular;
use App\Services\AsistenciaModularService;
use App\Services\CalificacionService;
use App\Services\CargoProcesoService;
use App\Services\CicloLectivoService;
use App\Services\ProcesoModularService;
use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PHPUnit\Util\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProcesoModularController extends Controller
{

    public const TIPO_PARCIAL = 1;
    public const TIPO_TP = 2;
    public const TIPO_TFI = 3;

    /**
     * @var CicloLectivoService
     */
    private $cicloLectivoService;
    /**
     * @var CargoProcesoService
     */
    private $cargoProcesoService;

    /**
     * @param CicloLectivoService $cicloLectivoService
     * @param CargoProcesoService $cargoProcesoService
     */
    public function __construct(
        CicloLectivoService $cicloLectivoService,
        CargoProcesoService $cargoProcesoService)
    {
        $this->middleware('app.auth', ['except' => 'delete']);
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente-profesor-areaSocial',
            ['except' => 'delete']);
        $this->cicloLectivoService = $cicloLectivoService;
        $this->cargoProcesoService = $cargoProcesoService;
    }

    /**
     * Muestra los procesos de los cargos de cada módulo ponderados.
     * @param int|null $ciclo_lectivo
     * @param int|null $cargo_id
     * @return Application|Factory|View
     */
    public function listado(Materia $materia, int $ciclo_lectivo = null, int $cargo_id = null)
    {

//        $materia = Materia::find($materia);


        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        $cargo = Cargo::find($cargo_id);

        $puedeProcesar = false;

        if ($cargo && Auth::user()->hasCargo($cargo_id) && $cargo->responsableTFI($materia->id)) {
            $puedeProcesar = true;
        }

        if (Auth::user()->hasAnyRole('coordinador') || Auth::user()->hasAnyRole('admin')) {
            $puedeProcesar = true;
        }

        $user = Auth::user();

        $acciones = [];

        $serviceModular = new ProcesoModularService();

        $proc = $serviceModular->obtenerProcesosByMateria($materia->id, $ciclo_lectivo);

        $arrayProcesos = $proc->pluck('id')->toArray();


        $procesosModulares = $serviceModular->obtenerProcesosModularesByIdProcesos($arrayProcesos);

        $cantidad_procesos_no_vinculados = $serviceModular->obtenerProcesosModularesNoVinculadosByProcesos(
            $arrayProcesos, $materia->id, $ciclo_lectivo);

        if (count($cantidad_procesos_no_vinculados) > 0) {

            $acciones[] = "Creando procesos modulares para {$materia->nombre}";
            $serviceModular->crearProcesoModular($materia->id, $ciclo_lectivo);
            $serviceModular->cargarPonderacionEnProcesoModular($materia, $ciclo_lectivo);

            /**
             * Genero los cargos procesos si no existen.
             */

            foreach ($materia->cargos()->get() as $cargo) {
                foreach ($procesosModulares as $procesoModular) {
                    $this->cargoProcesoService->grabaNotaPonderadaCargo(
                        $cargo->id,
                        $ciclo_lectivo,
                        $procesoModular->proceso_id,
                        $materia->id,
                        $user->id);
                }

                if ($cargo->responsableTFI($materia->id) && $user->hasCargo($cargo->id)) {
                    $puedeProcesar = true;
                }
            }

            $acciones[] = "Procesando % modulares para {$materia->nombre}";
            $asistenciaModular = new AsistenciaModularService();

            $asistencias = $asistenciaModular->cargarPonderacionEnAsistenciaModular($materia, $ciclo_lectivo);

            if ($asistencias > 0) {
                $acciones[] = "Procesando % asistencia para {$materia->nombre}";
            }
        }

        $estados = Estados::all();

        return view('procesoModular.listado', [
                'materia' => $materia,
                'cargo_id' => $cargo_id,
                'acciones' => $acciones,
                'procesos' => $procesosModulares,
                'puede_procesar' => $puedeProcesar,
                'estados' => $estados,
                'ciclo_lectivo' => $ciclo_lectivo,
                'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            ]
        );
    }

    public function procesaPonderacionModular(Materia $materia)
    {
        $acciones = [];
        $serviceModular = new ProcesoModularService();
        if (count($serviceModular->obtenerProcesosModularesNoVinculados($materia->id)) > 0) {
            $acciones[] = "Creando procesos modulares para {$materia->nombre}";
            $serviceModular->crearProcesoModular($materia->id);
            $serviceModular->cargarPonderacionEnProcesoModular($materia);
        }


    }

    public function procesaEstadosModular(Materia $materia, $ciclo_lectivo, int $cargo_id = null): RedirectResponse
    {
        $service = new ProcesoModularService();
        $service->grabaEstadoCursoEnModulo($materia->id, $ciclo_lectivo);

        return redirect()->route(
            'proceso_modular.list',
            ['materia' => $materia, 'ciclo_lectivo' => $ciclo_lectivo, 'cargo_id' => $cargo_id]);

    }

    public function procesaNotaModular($materia, int $proceso_id, $cargo_id = null): RedirectResponse
    {

        $service = new ProcesoModularService();

        /** @var Proceso $proceso */
        $proceso = Proceso::find($proceso_id);

        if (!$proceso) {
            throw new Exception('No se encontró el proceso');
        }

        $materia = Materia::find($materia);

        if (!$materia) {
            throw new Exception('No se encontró la materia');
        }

        $cargos = $service->obtenerCargosPorModulo($materia)->pluck('id');

        $message = null;
        foreach ($cargos as $cargo) {
            $cargoProceso = CargoProceso::where([
                'proceso_id' => $proceso->id,
                'cargo_id' => $cargo
            ])->first();
            if ($cargoProceso) {
                $this->actualizaCargoProceso($cargo, $proceso, $materia, $cargoProceso);
            } else {
                Session::flash('message',
                    'No se han agregado las notas del alumno al módulo.
                    Se debe hacer desde las Notas de proceso cargo');
            }
        }


        $nota_proceso = $service->revisaNotasProceso($materia, $proceso);
        $porcentaje = $service->revisaPorcentajeProceso($materia, $proceso);

        $service->setNotaProceso($proceso_id, $nota_proceso);
        $service->setPorcentajeProceso($proceso_id, $porcentaje / 100);

        return redirect()->route('proceso_modular.list',
            ['materia' => $materia,
                'ciclo_lectivo' => $proceso->ciclo_lectivo,
                'cargo_id' => $cargo_id]);
    }


    public function procesaNotaModularProceso($materia, int $proceso_id, int $cargo_id = null)
    {
        $user = Auth::user();
        $puedeProcesar = false;

        /** @var Proceso $proceso */
        $proceso = Proceso::find($proceso_id);
        if (!$proceso) {
            throw new NotFoundHttpException('No se encontró el proceso indicado');
        }

        /** @var Materia $materia */
        $materia = Materia::find($materia);
        if (!$materia) {
            throw new NotFoundHttpException('No se encontró la materia indicada');
        }

        if ($cargo_id) {
            $cargoGeneral = Cargo::find($cargo_id);
            if (!$cargoGeneral) {
                throw new NotFoundHttpException('No se encontró el cargo indicado');
            }
            if (Auth::user()->hasCargo($cargo_id)
                && $cargoGeneral->responsableTFI($materia->id)) {
                $puedeProcesar = true;
            }
        }

        $procesoModular = ProcesoModular::where([
            'proceso_id' => $proceso->id])
            ->first();

        if (!$procesoModular) {
            $data['proceso_id'] = $proceso->id;
            $data['ciclo_lectivo'] = $proceso->ciclo_lectivo;
            $procesoModular = ProcesoModular::create($data);
        }

        $service = new ProcesoModularService();

        $cargos = $service->obtenerCargosPorModulo($materia)->pluck('id');

        foreach ($cargos as $cargo) {
            $cargoProceso = CargoProceso::where([
                'proceso_id' => $proceso->id,
                'cargo_id' => $cargo
            ])->first();
            if ($cargoProceso) {
                $this->actualizaCargoProceso($cargo, $proceso, $materia, $cargoProceso);
            }
            $this->cargoProcesoService->grabaNotaPonderadaCargo(
                $cargo,
                $proceso->ciclo_lectivo,
                $proceso->id,
                $materia->id,
                $user->id);
        }

        $nota_proceso = $service->revisaNotasProceso($materia, $proceso);
        $porcentaje = $service->revisaPorcentajeProceso($materia, $proceso);

        $service->setNotaProceso($proceso_id, $nota_proceso);
        $service->setPorcentajeProceso($proceso_id, $porcentaje / 100);

        if (Auth::user()->hasAnyRole('coordinador') || Auth::user()->hasAnyRole('admin')) {
            $puedeProcesar = true;
        }

        $asistenciaModular = new AsistenciaModularService();

        $asistenciaModular->calculateFinalAsistenciaModularPercentage($materia, $procesoModular);

        return view('procesoModular.filaProceso',
            [
                'proceso' => $procesoModular,
                'puede_procesar' => $puedeProcesar,
            ]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProcesoModular $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function show(ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProcesoModular $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProcesoModular $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProcesoModular $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * @param int $cargo_id
     * @param Proceso $proceso
     * @param Materia $materia
     * @param CargoProceso $cargoProceso
     * @return CargoProceso
     */
    protected function actualizaCargoProceso(
        int $cargo_id, Proceso $proceso, Materia $materia, CargoProceso $cargoProceso): CargoProceso
    {
        return $this->cargoProcesoService->actualizaCargoProceso($cargo_id, $proceso, $materia, $cargoProceso);
    }

    /**
     * Esta función carga las pestañas de un determinado Cargo en la vista 'procesoModular.cargo_tab'.
     *
     * @param mixed $cargo_id El ID del Cargo que se va a buscar.
     * @param mixed $materia_id El ID de la Materia que se va a buscar.
     * @param mixed $ciclo_lectivo El ciclo lectivo al cual pertenece el Cargo y la Materia.
     * @param int|null $comision_id (opcional) El ID de la Comisión a la que pertenece
     *                              el Cargo y la Materia. Si no se proporciona, será null.
     *
     * @return \Illuminate\View\View Devuelve una vista llamada 'procesoModular.cargo_tab'
     *                  con un array de datos que incluye las Calificaciones ordenadas por
     *                                         tipo, el Cargo y los Procesos de la Materia.
     */
    public function cargaTabsCargo($cargo_id, $materia_id, $ciclo_lectivo, int $comision_id = null)
    {
        $cargo = Cargo::find($cargo_id);
        $materia = Materia::find($materia_id);

        $ponderacion = $cargo->ponderacion($materia->id);

        $calificaciones = $this->obtenerCalificacionesOrdenadasPorTipo($cargo_id, $materia_id, $ciclo_lectivo);

        $procesos = $materia->getProcesos($ciclo_lectivo, $comision_id);

        return view('procesoModular.cargo_tab',
            ['calificaciones' => $calificaciones,
                'cargo' => $cargo,
                'procesos' => $procesos,
                'ponderacion' => $ponderacion
            ]);
    }

    private function obtenerCalificacionesOrdenadasPorTipo($cargo_id, $materia_id, $ciclo_lectivo)
    {
        // Obtiene el cargo.
        $cargo = Cargo::find($cargo_id);


        // Obtener las calificaciones de la relación entre el cargo y la materia
        // Asume que las relaciones están definidas en tus modelos
        // Ordena las calificaciones por el campo 'tipo_id'.
        $calificaciones = $cargo->calificacionesCargo()
            ->where('materia_id', $materia_id)
            ->where('ciclo_lectivo', $ciclo_lectivo)
            ->orderBy('tipo_id')->get();

        return $calificaciones;
    }


}
