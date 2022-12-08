<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Configuration;
use App\Models\Estados;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesoModular;
use Illuminate\Database\Eloquent\Collection;


class ProcesoModularService
{
    /**
     * Mirando👆 Módulos sería Acreditación Directa si
     *  [X] Asistencia Módulo > 75%,
     *  [X] Proceso >60%,
     *  [X] Promedio >78% y
     *  [X] TFI >78%
     * Regular si
     *  [X] Asistencia Módulo >= 60
     *  [X] PP 100%,
     *  [X] Promedio Proceso >= 60,
     *  [X] Asistencia por cargo >= 40
     *  [X] TFI >= 60
     */
    const ASISTENCIA_ACCREDITATION_DIRECTA = 75;
    const PROCESO_ACCREDITATION_DIRECTA = 60;
    const PROMEDIO_ACCREDITATION_DIRECTA = 78;
    const TFI_ACCREDITATION_DIRECTA = 78;

    const ASISTENCIA_MIN_REGULAR = 60;
    const ASISTENCIA_MAX_REGULAR = 75;
    const ASISTENCIA_MIN_CARGO_REGULAR = 40;
    const ASISTENCIA_PRACTICA_PROFESIONAL = 100;


    const PROMEDIO_MIN_REGULAR = 60;
    const PROMEDIO_MAX_REGULAR = 78;
    const TFI_MIN_REGULAR = 60;
    const TFI_MAX_REGULAR = 78;
    /**
     * @var CalificacionService
     */
    private $calificacionService;
    /**
     * @var ProcesoCalificacionService
     */
    private $procesoCalificacionService;


//    /**
//     * @param CalificacionService $calificacionService
//     * @param ProcesoCalificacionService $procesoCalificacionService
//     */
//    public function __construct(CalificacionService $calificacionService, ProcesoCalificacionService $procesoCalificacionService)
//    {
//        $this->calificacionService = $calificacionService;
//        $this->procesoCalificacionService = $procesoCalificacionService;
//    }

    /**
     * @param $materia_id <b>id</b> materia
     * @return void
     */
    public function crearProcesoModular(int $materia_id)
    {
        $pm_sin_vincular = $this->obtenerProcesosModularesNoVinculados($materia_id);
        $inicio = 0;
        foreach ($pm_sin_vincular as $pm) {
            $data['proceso_id'] = $pm->id;
            ProcesoModular::create($data);
            $inicio += 1;
        }

    }

    /**
     * @param int $materia_id <b>id</b> materia
     * @return mixed
     */
    public function obtenerProcesosModularesNoVinculados(int $materia_id)
    {
        $procesos = Proceso::select('procesos.id')
            ->where('materia_id', '=', $materia_id)
            ->get();

        return Proceso::select('procesos.id')
            ->where('procesos.materia_id', $materia_id)
            ->whereNotIn(
                'procesos.id',
                ProcesoModular::select('proceso_modular.proceso_id')
                    ->whereIn('proceso_modular.proceso_id', $procesos)
            )
            ->get();
    }

    /**
     * ProcesoModularService.php:147
     * @param $materia_id <b>id</b> de la materia
     * @return mixed
     */
    public function obtenerProcesosModularesByMateria($materia_id)
    {
        return ProcesoModular::select('proceso_modular.*')
            ->join('procesos', 'procesos.id', 'proceso_modular.proceso_id')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->orderBy('alumnos.apellidos', 'asc')
            ->get();
    }

    /**
     * Revisar porque no devuelve lo que se espera
     * @param Materia $materia
     * @return Collection
     */

    public function ponderarCargos(Materia $materia): Collection
    {
        $cargos = $materia->cargos()->get();
        foreach ($cargos as $cargo) {
            /** @var Cargo $cargo */
            $cargo->calificacionesTPByCargoByMateria($materia->id);
        }

        return $materia->cargos()->get();
    }

    /**
     * ProcesoModularController.php:57
     * @param Materia $materia
     * @return int
     */
    public function cargarPonderacionEnProcesoModular(Materia $materia): int
    {
        $this->crearProcesoModular($materia->id);

        $procesoCalificacionService = new ProcesoCalificacionService();

        $serviceCargo = new CargoService();
        $serviceProcesoCalificacion = new ProcesoCalificacionService();
        $cant = 0;
        $cargos = $this->obtenerCargosPorModulo($materia);
        $promedio_final_p = 0;
        $procesos = $this->obtenerProcesosModularesByMateria($materia->id);
        foreach ($procesos as $proceso) {
            $promedio_final_p = 0;
            /** @var Cargo $cargo */
            foreach ($cargos as $cargo) {
                /** @var ProcesoModular $proceso */
                $ponderacion_cargo_materia = CargoMateria::where([
                    'cargo_id' => $cargo->id,
                    'materia_id' => $materia->id,
                ])->first();
                $porcentaje_cargo = $serviceCargo->calculoPorcentajeCalificacionPorCargoAndProceso(
                    $cargo,
                    $materia->id,
                    $proceso->procesoRelacionado()->first()->id
                ) ?? 0;
                if ($porcentaje_cargo < -1) {
                    $porcentaje_cargo = 0;
                }

                $ponderacion_asignada = $ponderacion_cargo_materia->ponderacion ?? 0;
                $promedio_final_p += $porcentaje_cargo * $ponderacion_asignada / 100;

            }
            $proceso->promedio_final_porcentaje = $promedio_final_p;
            $proceso->promedio_final_nota = $nota = $serviceProcesoCalificacion->calculoPorcentajeNota(
                $promedio_final_p
            );

            if (!$proceso->trabajo_final_porcentaje) {
                if ($cargo->responsableTFI($materia->id)) {
                    $tfp = $procesoCalificacionService->obtenerProcesoCalificacionByProcesoMateriaCargoTipo(
                        $proceso->procesoRelacionado()->first()->id,
                        $materia->id,
                        $cargo->id,
                        CalificacionService::TIPO_TFI
                    )->first();
                    if($tfp) {
                        $proceso->trabajo_final_porcentaje = $tfp->porcentaje;
                        $proceso->trabajo_final_nota = $tfp->nota;
                    }
                }
            }

            $proceso->nota_final_porcentaje = $proceso->trabajo_final_porcentaje * 0.2 + $proceso->promedio_final_porcentaje * 0.8;
            $proceso->nota_final_nota = $serviceProcesoCalificacion->calculoPorcentajeNota(
                $proceso->nota_final_porcentaje
            );

            $proceso->update();

            $cant += 1;

        }

        $this->grabaEstadoCursoEnModulo($materia->id);

        return $cant;

    }

    /**
     * @param Materia $modulo
     * @return Collection
     */
    public function obtenerCargosPorModulo(Materia $modulo): Collection
    {
        return $modulo->cargos()->get();
    }

    public function obtenerTimeUltimaCalificacion($materia_id)
    {
        $serviceProcesoCalificacion = new ProcesoCalificacionService();

        return $serviceProcesoCalificacion->obtenerTimeUltimaCalificacionPorModulo($materia_id);
    }

    /**
     * @param $materia_id
     * @return mixed
     */
    public function obtenerTimeUltimoProcesoModular($materia_id)
    {
        return ProcesoModular::select('proceso_modular.updated_at')
            ->join('procesos', 'procesos.id', 'proceso_modular.proceso_id')
            ->where('procesos.materia_id', $materia_id)
            ->orderBy('proceso_modular.updated_at', 'desc')
            ->first();
    }

    /**
     * @param $materia_id <b>Módulo</b> a procesar
     * @return string[] <i>200</i> si generó todos los estados
     */
    public function grabaEstadoCursoEnModulo($materia_id): array
    {

        $estados_procesados = [];

        $procesosModulares = $this->obtenerProcesosModularesByMateria($materia_id);


        foreach ($procesosModulares as $pm) {
            /** @var ProcesoModular $pm */
            $estado = $this->grabaEstadoPorProcesoModular($pm);
            $estados_procesados[] = [$pm->id => $estado];
        }

        return $estados_procesados;
    }

    /**
     * @param ProcesoModular $pm
     * @return bool
     */
    public function regularityDirectAccreditation(ProcesoModular $pm): bool
    {

        /** @var Proceso $proceso */
        $proceso = $pm->procesoRelacionado()->first();

        return (
            $this->getAsistenciaModularBoolean(self::ASISTENCIA_ACCREDITATION_DIRECTA, $proceso)
            and
            $this->getCalificacionModularBoolean(self::PROCESO_ACCREDITATION_DIRECTA, $proceso)
            and
            $this->getPromedioModularBoolean(self::PROMEDIO_ACCREDITATION_DIRECTA, $pm->promedio_final_porcentaje)
            and
            $this->getTFIModularBoolean(self::TFI_ACCREDITATION_DIRECTA, $pm->trabajo_final_porcentaje)
        );
    }

    /**
     * @param ProcesoModular $pm
     * @return bool
     */
    public function regularityRegular(ProcesoModular $pm): bool
    {

        /** @var Proceso $proceso */
        $proceso = $pm->procesoRelacionado()->first();

        return (
            $this->getAsistenciaModularBoolean(self::ASISTENCIA_MAX_REGULAR, $proceso, self::ASISTENCIA_MIN_REGULAR)
            and
            $this->getCalificacionModularBoolean(self::PROMEDIO_MIN_REGULAR, $proceso)
            and
            $this->getTFIModularBoolean(self::TFI_MIN_REGULAR, $pm->promedio_final_porcentaje)
        );

    }


    /**
     * @param int $porcentaje_max
     * @param Proceso $proceso
     * @param int|null $porcentaje_min
     * @return bool
     */
    public function getAsistenciaModularBoolean(int $porcentaje_max, Proceso $proceso, int $porcentaje_min = null): bool
    {
        $cargos = $proceso->materia()->first()->cargos()->get();

        $asistencia_modular = 0;

        $asistencia_modular_service = new AsistenciaModularService();
        foreach ($cargos as $cargo) {

            $pondera_cargo = $asistencia_modular_service->getPorcentajeCargoAsistencia(
                $proceso->materia()->first(),
                $cargo
            );
            /** @var Cargo $cargo */
            if ($proceso->asistencia() and $proceso->asistencia()->getByAsistenciaCargo($cargo->id)) {
                if ($proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje
                    < self::ASISTENCIA_MIN_CARGO_REGULAR) {
                    return false;
                }
                if ($porcentaje_min) {
                    if ($cargo->isPracticaProfesional()) {
                        if ($proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje
                            < self::ASISTENCIA_PRACTICA_PROFESIONAL) {
                            return false;
                        }
                    }
                }
            } else {
                return false;
            }
            $asistencia_modular += $pondera_cargo * $proceso->asistencia()->getByAsistenciaCargo(
                    $cargo->id
                )->porcentaje;
        }

        $porcentaje = $porcentaje_min ?? $porcentaje_max;


        return $asistencia_modular >= $porcentaje;
    }

    /**
     * @param int $porcentaje
     * @param Proceso $proceso
     * @return bool
     */
    public function getCalificacionModularBoolean(int $porcentaje, Proceso $proceso): bool
    {
        $serviceCargo = new CargoService();
        $materia_id = $proceso->materia()->first()->id;
//        $alumno_id = $proceso->alumno()->first()->id;
        $proceso_id = $proceso->id;
        $cargos = $proceso->materia()->first()->cargos()->get();
        foreach ($cargos as $cargo) {

//            if ($porcentaje > $serviceCargo->calculoPorcentajeCalificacionPorCargo(
//                    $cargo,
//                    $materia_id,
//                    $proceso_id
//                )) {
//                return false;
//            }
            if ($porcentaje > $this->processProceso(
                    $proceso_id,
                    $materia_id,
                    $cargo->id
                )) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $porcentaje_max
     * @param float $promedio_final
     * @return bool
     */
    public function getPromedioModularBoolean(int $porcentaje_max, float $promedio_final): bool
    {
        return $promedio_final >= self::PROMEDIO_ACCREDITATION_DIRECTA;
    }

    /**
     * @param int $porcentaje_max
     * @param int $trabajo_final_porcentaje
     * @return bool
     */
    public function getTFIModularBoolean(int $porcentaje_max, int $trabajo_final_porcentaje): bool
    {
        return $trabajo_final_porcentaje >= $porcentaje_max;
    }

    /**
     * @param ProcesoModular $pm
     * @return int
     */
    public function grabaEstadoPorProcesoModular(ProcesoModular $pm): int
    {
        $idEstado = $pm->procesoRelacionado()->first()->estado_id;
        if ($pm->procesoRelacionado()->first()->cierre != 1) {
            if ($this->regularityDirectAccreditation($pm)) {
                $estado = Estados::where(
                    ['identificador' => 4]
                )->first();
            } else {

                if ($this->regularityRegular($pm)) {
                    $estado = Estados::where(
                        ['identificador' => 1]
                    )->first();
                } else {
                    $estado = Estados::where(
                        ['identificador' => 5]
                    )->first();
                }

            }

            $proceso = $pm->procesoRelacionado()->first();
            $proceso->estado_id = $estado->id;
            $proceso->update();
            $idEstado = $estado->id;
        }

        return $idEstado;
    }


    public function obtengoPorcentajeFinalProcesoPorProcesoMateriaCargo($proceso, $materia, $cargo)
    {
        $parciales = $this->procesoCalificacionService->
        obtenerProcesoCalificacionByProcesoMateriaCargoTipo(
            $proceso,
            $materia,
            $cargo,
            $this->calificacionService::TIPO_PARCIAL
        );
        $trabajos_p = $this->procesoCalificacionService->
        obtenerProcesoCalificacionByProcesoMateriaCargoTipo(
            $proceso,
            $materia,
            $cargo,
            $this->calificacionService::TIPO_TP
        );
        $trabajos_f = $this->procesoCalificacionService->
        obtenerProcesoCalificacionByProcesoMateriaCargoTipo(
            $proceso,
            $materia,
            $cargo,
            $this->calificacionService::TIPO_TFI
        );

    }

    /**
     * @param $proceso
     * @param $materia
     * @param $cargo
     * @return float
     */
    public function processProceso($proceso, $materia, $cargo): float
    {
        $pCS = new ProcesoCalificacionService();
        $final_cargo = 0;
        $cant_p = 0;
        $cant_tp = 0;
        $total_p = 0;
        $total_tp = 0;
        $parciales = $pCS->
        obtenerProcesoCalificacionByProcesoMateriaCargoTipo(
            $proceso,
            $materia,
            $cargo,
            CalificacionService::TIPO_PARCIAL
        );
        $tps = $pCS->
        obtenerProcesoCalificacionByProcesoMateriaCargoTipo(
            $proceso,
            $materia,
            $cargo,
            CalificacionService::TIPO_TP
        )->pluck('porcentaje');
        $cant_p = count($parciales);
        foreach ($parciales as $parcial) {
            $pp = 0;
            $ppr = 0;
            if (is_numeric($parcial->porcentaje)) {
                $pp = $parcial->porcentaje;
            }
            if (is_numeric($parcial->porcentaje_recuperatorio)) {
                $ppr = $parcial->porcentaje_recuperatorio;
            }

            $total_p += max($pp, $ppr);
        }
        $cant_tp = count($tps);
        foreach ($tps as $tp) {
            $total_tp += max($tp, 0);
        }

        $cargoService = new CargoService();

        return $cargoService->calculoPorcentajeCalificacionFromBlade($cant_tp, $total_tp, $cant_p, $total_p);

    }


}