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
use Illuminate\Support\Collection;

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
     * @param ProcesosCargosService $procesosCargosService
     */
    public function __construct(
        CalificacionService   $calificacionService, ProcesoCalificacionService $procesoCalificacionService,
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
                [$tps->id], $proceso) as $notas) {
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

    /**
     * Recupera el alumno_id asociado con el proceso dado.
     *
     * @param int $proceso El ID del proceso para obtener el alumno_id.
     *
     * @return int El alumno_id asociado con el proceso.
     */
    public function getAlumnoId(int $proceso): int
    {
        return Proceso::find($proceso)->alumno_id;
    }


    /**
     * Recupera la ponderación del cargo.
     *
     * @param int $cargo ID del cargo.
     * @param int $materia ID de la materia.
     *
     * @return float Ponderación para la materia en el cargo especificado.
     */
    public function getWeighingCargo(int $cargo, int $materia): float
    {
        $cargo = Cargo::find($cargo);
        return $cargo->ponderacion($materia);
    }

    /**
     * Obtiene el ciclo lectivo asociado al proceso dado.
     *
     * @param int $proceso El ID del proceso para obtener el ciclo lectivo.
     *
     * @return int El ciclo lectivo asociado con el proceso.
     */
    public function getCicloLectivo(int $proceso): int
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
     * Graba la calificación de un cargo.
     *
     * @param mixed $cargo El cargo al que se le va a grabar la calificación.
     * @param mixed $cicloLectivo El ciclo lectivo al que pertenece el cargo.
     * @param mixed $proceso El proceso al que pertenece el cargo.
     * @param mixed $materia La materia a la que corresponde el cargo.
     * @param mixed $user El usuario que realiza la grabación de la calificación.
     *
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

        list($tps, $parciales) = $this->getCalificacionesDetails($cargo, $proceso, $materia);

        $sumaTps = $this->calculateSumaTps($proceso->id, $tps);

        $sumaPs = $this->calculateSumaPs($proceso->id, $parciales);

        $total_cargo = $this->procesoModularService->getNotaCargo(count($tps), count($parciales), $sumaTps, $sumaPs);

        $ponderacion_cargo = $this->procesoModularService->getPonderacionCargo($total_cargo, $cargo, $materia->id);

        $porcentajeAsistencia = $this->calculatePorcentajeAsistencia($proceso->id, $cargo);

        return $this->updateCargoProceso(
            $cargoProceso, $tps, $parciales,
            $sumaTps, $sumaPs, $total_cargo,
            $ponderacion_cargo, $porcentajeAsistencia);

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
                    $cargo_id, $proceso->id, $user_id, $ciclo_lectivo);
            }

            $this->actualizaCargoProceso($cargo_id, $proceso, $materia, $cargoProceso);
        }
    }

    /**
     * Recupera las calificaciones dados un tipo, cargo, proceso y materia.
     *
     * @param int $tipo El tipo de calificaciones a recuperar.
     * @param int $cargo El cargo id.
     * @param Proceso $proceso El proceso objeto.
     * @param Materia $materia La materia objeto.
     * @return Collection Collection de calificaciones.
     */
    private
    function getCalificaciones(int $tipo, int $cargo, Proceso $proceso, Materia $materia): Collection
    {
        return $this->calificacionService->calificacionesInCargos(
            [$cargo], $proceso->ciclo_lectivo, [$tipo], $materia->id);
    }

    /**
     * Obtiene los detalles de las calificaciones para un cargo, proceso y materia dados.
     *
     * @param int $cargo El ID del cargo.
     * @param Proceso $proceso El objeto del proceso.
     * @param Materia $materia El objeto de la materia.
     * @return array Un array que contiene los detalles de las calificaciones,
     * donde el primer elemento del array son las calificaciones de los Trabajos Prácticos (TPs)
     *               y el segundo elemento del array son las calificaciones parciales.
     */
    private function getCalificacionesDetails(int $cargo, Proceso $proceso, Materia $materia): array
    {
        $tps = $this->getCalificaciones(self::TIPO_TP, $cargo, $proceso, $materia);
        $parciales = $this->getCalificaciones(self::TIPO_PARCIAL, $cargo, $proceso, $materia);

        return [$tps, $parciales];
    }

    /**
     * Calcula la suma de las notas de los trabajos prácticos (TPs) para un proceso dado.
     *
     * @param int $id El ID del proceso.
     * @param Collection $tps Un array de objetos TP asociados con el proceso.
     * @return int|null La suma total de las notas de los TPs. Si no existen TPs, retorna null.
     */
    private function calculateSumaTps(int $id, Collection $tps): ?int
    {
        $notasTps = $this->calificacionService->calificacionesArrayByProceso($id, $tps->pluck('id')->toArray());
        $sumaTps = 0;

        foreach ($notasTps as $tp) {
            if (is_numeric($tp->nota) && $tp->nota >= 0) {
                $sumaTps += $tp->nota;
            }
        }

        return $sumaTps;
    }

    /**
     * Calcula la suma de las calificaciones parciales para un proceso dado.
     *
     * @param int $procesoId El ID del proceso.
     * @param Collection $parciales Un array de objetos parciales asociados con el proceso.
     * @return int|null La suma total de las calificaciones parciales. Si no existen parciales, retorna null.
     */
    private function calculateSumaPs(int $procesoId, Collection $parciales): ?int
    {
        $sumaPs = 0;

        foreach ($parciales as $ps) {
            $calificacionParcial = $this->calificacionService->calificacionParcialByProceso($procesoId, $ps->id);

            if (is_numeric($calificacionParcial)) {
                $sumaPs += $calificacionParcial;
            }
        }

        return $sumaPs;
    }

    /**
     * Calcula el porcentaje de asistencia para un proceso y cargo dado.
     *
     * @param int $procesoId El ID del proceso.
     * @param int $cargo El ID del cargo.
     * @return float|null El porcentaje de asistencia. Si no se encuentra la asistencia, retorna null.
     */
    private function calculatePorcentajeAsistencia(int $procesoId, int $cargo): ?float
    {
        $asistencia = Asistencia::where(['proceso_id' => $procesoId])->first();

        if ($asistencia) {
            $asistenciaModular = AsistenciaModular::where(
                ['asistencia_id' => $asistencia->id, 'cargo_id' => $cargo]
            )->first();
            if ($asistenciaModular) {
                return $asistenciaModular->porcentaje;
            }
        }

        return null;
    }

    /**
     * Actualiza un objeto CargoProceso con los valores de trabajos prácticos,
     * parciales, sumas y porcentaje de asistencia dados.
     *
     * @param CargoProceso $cargoProceso El objeto CargoProceso a actualizar.
     * @param array $tps Un array de objetos Trabajos Prácticos (TPs).
     * @param array $parciales Un array de objetos parciales.
     * @param int|null $sumaTps La suma total de las calificaciones de los TPs.
     * @param int|null $sumaPs La suma total de las calificaciones parciales.
     * @param float $total_cargo La nota total del cargo.
     * @param float $ponderacion_cargo La nota ponderada del cargo.
     * @param float|null $porcentajeAsistencia El porcentaje de asistencia.
     * @return CargoProceso Retorna el objeto CargoProceso actualizado.
     */
    private function updateCargoProceso(
                                        CargoProceso $cargoProceso, $tps, $parciales,
                                        ?int         $sumaTps, ?int $sumaPs, $total_cargo,
                                        $ponderacion_cargo, ?float $porcentajeAsistencia): CargoProceso
    {
        $cargoProceso->cantidad_tp = count($tps);
        $cargoProceso->cantidad_ps = count($parciales);
        $cargoProceso->suma_tp = $sumaTps;
        $cargoProceso->suma_ps = $sumaPs;
        $cargoProceso->nota_tp = count($tps) > 0 && $sumaTps > 0 ? $sumaTps / count($tps) : null;
        $cargoProceso->nota_ps = count($parciales) > 0 && $sumaPs > 0 ? $sumaPs / count($parciales) : null;
        $cargoProceso->nota_cargo = $total_cargo;
        $cargoProceso->nota_ponderada = $ponderacion_cargo;
        $cargoProceso->porcentaje_asistencia = $porcentajeAsistencia;

        $cargoProceso->update();

        return $cargoProceso;
    }
}
