<?php

namespace App\Services;

use App\Models\Asistencia;
use App\Models\AsistenciaModular;
use App\Models\Cargo;
use App\Models\CargoProceso;
use App\Models\Configuration;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesosCargos;

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
     * @var ProcesoModularService
     */
    private $procesoModularService;
    private ProcesosCargosService $procesosCargosService;

    /**
     * @param CalificacionService $calificacionService
     * @param ProcesoCalificacionService $procesoCalificacionService
     * @param ProcesoModularService $procesoModularService
     */
    public function __construct(
        CalificacionService $calificacionService, ProcesoCalificacionService $procesoCalificacionService,
        ProcesoModularService $procesoModularService, ProcesosCargosService $procesosCargosService)
    {
        $this->calificacionService = $calificacionService;
        $this->procesoCalificacionService = $procesoCalificacionService;
        $this->procesoModularService = $procesoModularService;
        $this->procesosCargosService = $procesosCargosService;
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
        $cantidadTps = $this->calificacionService->calificacionesInCargos(
            [$cargo], $ciclo_lectivo, [self::TIPO_TP], $materia);
        $cantidadPcs = $this->calificacionService->calificacionesInCargos(
            [$cargo], $ciclo_lectivo, [self::TIPO_PARCIAL], $materia);

        return [$cantidadTps, $cantidadPcs];
    }

    /**
     * @param $cargo
     * @param $cicloLectivo
     * @param $proceso
     * @param $materia
     * @param $user
     * @return array <b>Cantidad de Trabajos Prácticos y Cantidad de Parciales</b>
     */
    public function grabaCantidadesCalificacionesPorCargoYProcesos(
        $cargo, $cicloLectivo, $proceso, $materia, $user): array
    {
        list($trabajosPracticals, $parciales, $cargoProceso) = $this->getCargoProcesoYCalificaciones(
            $cargo, $cicloLectivo, $proceso, $materia, $user);

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
     * @return array <b>Suma de Trabajos Prácticos y Suma de Parciales</b>
     */
    public function grabaSumaCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user): array
    {
        list($trabajosPracticals, $parciales, $cargoProceso) = $this->getCargoProcesoYCalificaciones(
            $cargo, $cicloLectivo, $proceso, $materia, $user);

        $sumaTps = null;
        $sumaPs = null;

        foreach ($trabajosPracticals as $tps) {
            foreach ($this->procesoCalificacionService->obtenerNotaProcesoCalificacion(
                [$tps->id], $proceso) as $notas)
            {
                if (is_numeric($notas->nota) && $notas->nota > 0) {
                    $sumaTps += $notas->nota;
                }
            }
        }
        foreach ($parciales as $ps) {

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
        $cargoProceso = $this->getCargoProceso($cargo, $proceso, $user, $cicloLectivo);

        $cantidadTps = $cargoProceso->cantidad_tp;
        $cantidadPs = $cargoProceso->cantidad_ps;

        if (!$cantidadTps && !$cantidadPs) {
            list($cantidadTps, $cantidadPs) =
                $this->grabaCantidadesCalificacionesPorCargoYProcesos(
                    $cargo, $cicloLectivo, $proceso, $materia, $user);
        }

        list($sumaTps, $sumaPs) = $this->grabaSumaCalificaciones($cargo, $cicloLectivo, $proceso, $materia, $user);


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
     * @param $cicloLectivo
     * @return CargoProceso
     */
    public function grabaNuevoCargoProceso($cargo, $proceso, $user, $cicloLectivo): CargoProceso
    {
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

        $cargoProceso = $this->getCargoProceso($cargo, $proceso, $user, $cicloLectivo);
        return array($trabajosPracticals, $parciales, $cargoProceso);
    }

    /**
     * @param int $cargo
     * @param int $proceso
     * @param int $user
     * @param int $cicloLectivo
     * @return CargoProceso
     */
    public function getCargoProceso(int $cargo, int $proceso, int $user, int $cicloLectivo): CargoProceso
    {
        return $this->generaCargoProceso($cargo, $proceso, $user, $cicloLectivo);
    }

    /**
     * @param int $cargo
     * @param int $proceso
     * @param int $user
     * @param int $ciclo_lectivo
     * @return CargoProceso
     */
    public function generaCargoProceso(int $cargo, int $proceso, int $user, int $ciclo_lectivo): CargoProceso
    {
        $cargoProceso = CargoProceso::where([
            'cargo_id' => $cargo,
            'proceso_id' => $proceso
        ])->first();
        if (!$cargoProceso) {
            $cargoProceso = $this->grabaNuevoCargoProceso($cargo, $proceso, $user, $ciclo_lectivo);
        }

        return $cargoProceso;
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


    /**
     * Para hacer
     * @return void
     */
    public function procesaCargoProceso()
    {

    }


    /**
     * @param $cargo
     * @param $cicloLectivo
     * @param $proceso
     * @param $materia
     * @param $user
     * @return void
     */
    public function grabaCalificacion($cargo, $cicloLectivo, $proceso, $materia, $user): void
    {
        $this->grabaNotaPonderadaCargo($cargo, $cicloLectivo, $proceso, $materia, $user);
    }

    /**
     * Para hacer
     * @return void
     */
    public function getNotas()
    {
    }

    /**
     * @param int $cargo
     * @param Proceso $proceso
     * @param Materia $materia
     * @param CargoProceso $cargoProceso
     * @return CargoProceso
     */
    public function actualizaCargoProceso(
        int $cargo, Proceso $proceso, Materia $materia, CargoProceso $cargoProceso): CargoProceso
    {

        $tps = $this->calificacionService->calificacionesInCargos(
            [$cargo], $proceso->ciclo_lectivo, [self::TIPO_TP], $materia->id);

        $parciales = $this->calificacionService->calificacionesInCargos(
            [$cargo], $proceso->ciclo_lectivo, [self::TIPO_PARCIAL], $materia->id);

        $notasTps = $this->calificacionService->calificacionesArrayByProceso($proceso->id, $tps->pluck('id')->toArray());

        $sumaTps = null;
        foreach ($notasTps as $tps) {
            if (is_numeric($this->calificacionService->calificacionParcialByProceso($proceso->id, $tps->id))) {
                $sumaTps += $this->calificacionService->calificacionParcialByProceso($proceso->id, $tps->id);
            }
        }


//        $sumaTps = array_sum($notasTps->pluck('nota')->toArray());

        $sumaPs = null;

        foreach ($parciales as $ps) {
            if (is_numeric($this->calificacionService->calificacionParcialByProceso($proceso->id, $ps->id))) {
                $sumaPs += $this->calificacionService->calificacionParcialByProceso($proceso->id, $ps->id);
            }
        }

        $total_cargo = $this->procesoModularService->getNotaCargo(count($tps), count($parciales), $sumaTps, $sumaPs);

        $ponderacion_cargo = $this->procesoModularService->getPonderacionCargo($total_cargo, $cargo, $materia->id);

        $porcentajeAsistencia = null;

        $asistencia = Asistencia::where(
            [
                'proceso_id' => $proceso->id,
            ]
        )->first();

        if($asistencia) {
            $asistenciaModular = AsistenciaModular::where([
                'asistencia_id' => $asistencia->id,
                'cargo_id' => $cargo,

            ])->first();

            if ($asistenciaModular) {
                $porcentajeAsistencia = $asistenciaModular->porcentaje;
            }

        }
        $cargoProceso->cantidad_tp = count($tps);
        $cargoProceso->cantidad_ps = count($parciales);

        $cargoProceso->suma_tp = $sumaTps;
        $cargoProceso->suma_ps = $sumaPs;

        $notaTps = null;
        $notaParciales = null;
        if (count($tps) > 0 && $sumaTps > 0) {
            $notaTps = $sumaTps / count($tps);
        }
        if (count($parciales) > 0 && $sumaPs > 0) {
            $notaParciales = $sumaPs / count($parciales);
        }
        $cargoProceso->nota_tp = $notaTps;
        $cargoProceso->nota_ps = $notaParciales;

        $cargoProceso->nota_cargo = $total_cargo;
        $cargoProceso->nota_ponderada = $ponderacion_cargo;

        $cargoProceso->porcentaje_asistencia = $porcentajeAsistencia;

        $cargoProceso->update();

        return $cargoProceso;

    }

    /**
     * @param int $materia_id
     * @param int $cargo_id
     * @param int $ciclo_lectivo
     * @param int $user_id
     * @param int|null $comision_id
     * @return void
     */
    public function allStore(
        int $materia_id, int $cargo_id, int $ciclo_lectivo, int $user_id, int $comision_id = null)
    {
        /** @var Materia $materia */
        $materia = Materia::find($materia_id);

        $procesos = $materia->getProcesos($ciclo_lectivo, $comision_id);

        foreach ($procesos as $proceso) {
            $cargoProceso = CargoProceso::where([
                'proceso_id' => $proceso->id,
                'cargo_id' => $cargo_id
            ])->first();

            $procesosCargos = ProcesosCargos::where([
                'proceso_id' => $proceso->id,
                'cargo_id' => $cargo_id
            ])->first();

            if (!$procesosCargos) {
                $this->procesosCargosService->crear($proceso->id, $cargo_id, $user_id, false);
            }

            if (!$cargoProceso) {
                $cargoProceso = $this->generaCargoProceso(
                    $cargo_id, $proceso->id, $user_id, $ciclo_lectivo, false);
            }

            $this->actualizaCargoProceso($cargo_id, $proceso, $materia, $cargoProceso);
        }
    }
}
