<?php

namespace App\Http\Controllers;

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
use PHPUnit\Util\Exception;

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
    public function __construct(CicloLectivoService $cicloLectivoService, CargoProcesoService $cargoProcesoService)
    {
        $this->cicloLectivoService = $cicloLectivoService;
        $this->cargoProcesoService = $cargoProcesoService;
    }

    /**
     * Muestra los procesos de los cargos de cada módulo ponderados.
     * @param int|null $ciclo_lectivo
     * @param int|null $cargo_id
     * @return Application|Factory|View
     */
    public function listado($materia, int $ciclo_lectivo = null, int $cargo_id = null)
    {
        $materia = Materia::find($materia);

        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        $cargo = Cargo::find($cargo_id);

        $puedeProcesar = false;
        if ($cargo and Auth::user()->hasCargo($cargo_id) and $cargo->responsableTFI($materia->id)) {
            $puedeProcesar = true;
        }

        if (Auth::user()->hasAnyRole('coordinador') or Auth::user()->hasAnyRole('admin')) {
            $puedeProcesar = true;
        }
        $user = Auth::user();

        $acciones = [];
        $serviceModular = new ProcesoModularService();

        $procesos = $serviceModular->obtenerProcesosModularesByMateria($materia->id, $ciclo_lectivo);


        if (count($serviceModular->obtenerProcesosModularesNoVinculados($materia->id, $ciclo_lectivo)) > 0) {
            $acciones[] = "Creando procesos modulares para {$materia->nombre}";
            $serviceModular->crearProcesoModular($materia->id, $ciclo_lectivo);
            $serviceModular->cargarPonderacionEnProcesoModular($materia, $ciclo_lectivo);

            /**
             * Genero los cargos procesos si no existen.
             */

            foreach ($materia->cargos()->get() as $cargo) {
                foreach ($procesos as $proceso) {
                    $this->cargoProcesoService->grabaNotaPonderadaCargo(
                        $cargo->id,
                        $ciclo_lectivo,
                        $proceso->proceso_id,
                        $materia->id,
                        $user->id);
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
                'procesos' => $procesos,
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

        return redirect()->route('proceso_modular.list', ['materia' => $materia, 'ciclo_lectivo' => $ciclo_lectivo, 'cargo_id' => $cargo_id]);

    }

    public function procesaNotaModular($materia, int $proceso_id, $cargo_id = null): RedirectResponse
    {

        // 435 24053 12

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

        $calificacionService = new CalificacionService();


        foreach ($cargos as $cargo) {
            $cargoProceso = CargoProceso::where([
                'proceso_id' => $proceso->id,
                'cargo_id' => $cargo
            ])->first();
            $tps = $calificacionService->calificacionesInCargos([$cargo], $proceso->ciclo_lectivo, [self::TIPO_TP], $materia->id);
            $parciales = $calificacionService->calificacionesInCargos([$cargo], $proceso->ciclo_lectivo, [self::TIPO_PARCIAL], $materia->id);


            $notasTps = $calificacionService->calificacionesArrayByProceso($proceso->id, $tps->pluck('id'));

            $sumaTps = array_sum($notasTps->pluck('nota')->toArray());

            $sumaPs = null;

            foreach ($parciales as $ps) {
                if (is_numeric($calificacionService->calificacionParcialByProceso($proceso->id, $ps->id))) {
                    $sumaPs += $calificacionService->calificacionParcialByProceso($proceso->id, $ps->id);
                }
            }

            $total_cargo = $service->getNotaCargo(count($tps), count($parciales), $sumaTps, $sumaPs);

            $ponderacion_cargo = $service->getPonderacionCargo($total_cargo, $cargo, $materia->id);

            $porcentajeAsistencia = null;
//            $asistencia = AsistenciaModular::where([
//                'proceso_id' => $proceso->id,
//                'materia_id' => $materia->id,
//                'cargo_id' => $cargo,
//
//            ])->first();

//            if($asistencia){
//                $porcentajeAsistencia = $asistencia->porcentaje;
//            }


            if ($cargoProceso) {
                $cargoProceso->cantidad_tp = count($tps);
                $cargoProceso->cantidad_ps = count($parciales);

                $cargoProceso->suma_tp = $sumaTps;
                $cargoProceso->suma_ps = $sumaPs;

                $notaTps = null;
                $notaParciales = null;
                if (count($tps) > 0 and $sumaTps > 0) {
                    $notaTps = $sumaTps / count($tps);
                }
                if (count($parciales) > 0 and $sumaPs > 0) {
                    $notaParciales = $sumaPs / count($parciales);
                }
                $cargoProceso->nota_tp = $notaTps;
                $cargoProceso->nota_ps = $notaParciales;

                $cargoProceso->nota_cargo = $total_cargo;

                $cargoProceso->nota_ponderada = $ponderacion_cargo;

                $cargoProceso->porcentaje_asistencia = $porcentajeAsistencia;

                $cargoProceso->update();
            }

        }


        $nota_proceso = $service->revisaNotasProceso($materia, $proceso);


        $service->setNotaProceso($proceso_id, $nota_proceso);

        return redirect()->route('proceso_modular.list', ['materia' => $materia, 'ciclo_lectivo' => $proceso->ciclo_lectivo, 'cargo_id' => $cargo_id]);

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
}
