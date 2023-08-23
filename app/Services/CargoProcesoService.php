<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\CargoProceso;
use App\Models\Configuration;
use App\Models\Proceso;
use App\Models\ProcesoModular;

class CargoProcesoService
{
    public const TIPO_PARCIAL = 1;
    public const TIPO_TP = 2;
    public const TIPO_TFI = 3;
    /**
     * @var CalificacionService
     */
    private $calificacionService;
    /**
     * @var ProcesoCalificacionService
     */
    private $procesoCalificacionService;

    /**
     * @param CalificacionService $calificacionService
     * @param ProcesoCalificacionService $procesoCalificacionService
     */
    public function __construct(CalificacionService $calificacionService, ProcesoCalificacionService $procesoCalificacionService)
    {
        $this->calificacionService = $calificacionService;
        $this->procesoCalificacionService = $procesoCalificacionService;
    }

    /**
     * Obtiene la cantidad de calificaciones de un cargo por ciclo lectivo
     * @param $cargo
     * @param $ciclo_lectivo
     * @param $materia
     * @return array <b>Cantidad de Trabajos prácticos, Cantidad de parciales</b>
     */
    public function getCalificacionesPorCargo($cargo, $ciclo_lectivo, $materia): array
    {
        $cantidadTps = $this->calificacionService->calificacionesInCargos([$cargo], $ciclo_lectivo, [self::TIPO_TP], $materia);
        $cantidadPcs = $this->calificacionService->calificacionesInCargos([$cargo], $ciclo_lectivo, [self::TIPO_PARCIAL], $materia);

        return [$cantidadTps, $cantidadPcs];
    }

    /**
     * @param $cargo
     * @param $cicloLectivo
     * @param $proceso
     * @param $materia
     * @param $user
     * @return array
     */
    public function grabaCantidadesCalificacionesPorCargoYProcesos($cargo, $cicloLectivo, $proceso, $materia, $user): array
    {
        list($trabajosPracticals, $parciales, $cargoProceso) = $this->getCargoProcesoYCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user);

        $cargoProceso->cantidad_tp = count($trabajosPracticals);
        $cargoProceso->cantidad_ps = count($parciales);
        $cargoProceso->update();

        return [count($trabajosPracticals), count($parciales)];

    }

    /**
     * @param $cargo
     * @param $cicloLectivo
     * @param $proceso
     * @param $materia
     * @param $user
     * @return array
     */
    public function grabaSumaCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user): array
    {
        list($trabajosPracticals, $parciales, $cargoProceso) = $this->getCargoProcesoYCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user);

        $sumaTps = null;
        $sumaPs = null;

        foreach ($trabajosPracticals as $tps) {
            foreach ($this->procesoCalificacionService->obtenerNotaProcesoCalificacion([$tps->id], $proceso) as $notas) {
                if (is_numeric($notas->nota)) {
                    $sumaTps += $notas->nota;
                }
            }
        }
        foreach ($parciales as $ps) {
//            $sumaPs += $this->calificacionService->notaCalificacionParcialByAlumno($this->getAlumnoId($proceso), $ps->id);
            if (is_numeric($this->calificacionService->calificacionParcialByProceso($proceso, $ps->id))) {
                $sumaPs += $this->calificacionService->calificacionParcialByProceso($proceso, $ps->id);
            }
        }

        $cargoProceso->suma_tp = $sumaTps;
        $cargoProceso->suma_ps = $sumaPs;

        $cargoProceso->update();

        return [$sumaTps, $sumaPs];

    }

    /**
     * @param $cargo
     * @param $cicloLectivo
     * @param $proceso
     * @param $materia
     * @param $user
     * @return CargoProceso
     */
    public function grabaNotaCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user): CargoProceso
    {
        $cargoProceso = $this->getCargoProceso($cargo, $proceso, $user);

        $cantidadTps = $cargoProceso->cantidad_tp;
        $cantidadPs = $cargoProceso->cantidad_ps;

        if (!$cantidadTps and !$cantidadPs) {
            list($cantidadTps, $cantidadPs) = $this->grabaCantidadesCalificacionesPorCargoYProcesos($cargo, $cicloLectivo, $proceso, $materia, $user);
        }
//        $sumaTps = $cargoProceso->suma_tp;
//        $sumaPs = $cargoProceso->suma_ps;
//        if (!$sumaTps and !$sumaPs) {
        list($sumaTps, $sumaPs) = $this->grabaSumaCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user);
//        }

        $cargoProceso->nota_tp = 0;
        if ($cantidadTps > 0) {
            $cargoProceso->nota_tp = $sumaTps / $cantidadTps;
        }
        $cargoProceso->nota_ps = 0;
        if ($cantidadPs > 0) {
            $cargoProceso->nota_ps = $sumaPs / $cantidadPs;
        }

        $cargoProceso->update();

        return $cargoProceso;
    }


    /**
     * @param $cargo
     * @param $cicloLectivo
     * @param $proceso
     * @param $materia
     * @param $user
     * @return CargoProceso
     */
    public function grabaNotaCargo($cargo, $cicloLectivo, $proceso, $materia, $user): CargoProceso
    {
        $procesoCargo = $this->grabaNotaCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user);

        $configuration = Configuration::first();


        $total_cargo = 0;
        if ($configuration->value_parcial != null) {
            $value_parcial = $configuration->value_parcial / 100;
            $total_cargo = $procesoCargo->nota_tp * (1 - $value_parcial) + $procesoCargo->nota_ps * $value_parcial;
        } else {
            $cuenta = $procesoCargo->cantidad_tp + $procesoCargo->cantidad_ps;
            $suma = $procesoCargo->suma_tp + $procesoCargo->suma_ps;
            if ($cuenta > 0) {
                $total_cargo = $suma / $cuenta;
            }
        }


        $procesoCargo->nota_cargo = $total_cargo;

        $procesoCargo->update();

        return $procesoCargo;

    }


    /**
     * @param $cargo
     * @param $cicloLectivo
     * @param $proceso
     * @param $materia
     * @param $user
     * @return CargoProceso
     */
    public function grabaNotaPonderadaCargo($cargo, $cicloLectivo, $proceso, $materia, $user): CargoProceso
    {
        $cargoProceso = $this->grabaNotaCargo($cargo, $cicloLectivo, $proceso, $materia, $user);
        $weighing = $this->getWeighingCargo($cargo, $materia);

        $notaPonderadaCargo = $cargoProceso->nota_cargo * $weighing / 100;

        $cargoProceso->nota_ponderada = round($notaPonderadaCargo, 2);

        $cargoProceso->update();

        return $cargoProceso;
    }


    /**
     * Crea un CargoProceso
     * @param $cargo
     * @param $proceso
     * @param $user
     * @return CargoProceso
     */
    public function grabaNuevoCargoProceso($cargo, $proceso, $user): CargoProceso
    {
        $cicloLectivo = $this->getCicloLectivo($proceso);
        return CargoProceso::create([
            'user_id' => $user,
            'cargo_id' => $cargo,
            'proceso_id' => $proceso,
            'ciclo_lectivo' => $cicloLectivo
        ]);
    }

    /**
     * @param $cargo
     * @param $cicloLectivo
     * @param $proceso
     * @param $materia
     * @param $user
     * @return array
     */
    public function getCargoProcesoYCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user): array
    {
        list($trabajosPracticals, $parciales) = $this->getCalificacionesPorCargo($cargo, $cicloLectivo, $materia);

        $cargoProceso = $this->getCargoProceso($cargo, $proceso, $user);
        return array($trabajosPracticals, $parciales, $cargoProceso);
    }

    /**
     * @param $cargo
     * @param $proceso
     * @param $user
     * @return CargoProceso
     */
    public function getCargoProceso($cargo, $proceso, $user): CargoProceso
    {
        $cargoProceso = CargoProceso::where([
            'cargo_id' => $cargo,
            'proceso_id' => $proceso
        ])->first();
        if (!$cargoProceso) {
            $cargoProceso = $this->grabaNuevoCargoProceso($cargo, $proceso, $user);
        }
        return $cargoProceso;
    }

    public function generaCargoProceso($cargo, $proceso, $user): void
    {
        $cargoProceso = CargoProceso::where([
            'cargo_id' => $cargo,
            'proceso_id' => $proceso
        ])->first();
        if (!$cargoProceso) {
            $this->grabaNuevoCargoProceso($cargo, $proceso, $user);
        }
    }

    public function getAlumnoId(int $proceso)
    {
        return Proceso::find($proceso)->alumno_id;
    }

    public function getWeighingCargo(int $cargo, int $materia)
    {
        $cargo = Cargo::find($cargo);
        return $cargo->ponderacion($materia);
    }

    public function getCicloLectivo($proceso)
    {
        return Proceso::find($proceso)->ciclo_lectivo;
    }


    public function procesaCargoProceso()
    {

    }


}
