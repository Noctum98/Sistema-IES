<?php

namespace App\Services;

use App\Models\Calificacion;
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
     *  [X] Proceso >60%, nota >= 4
     *  [X] Promedio >78%, nota >= 7
     *  [X] TFI >78%, nota >= 7
     * Regular si
     *  [X] Asistencia Módulo >= 60
     *  [X] PP 100%,
     *  [X] Promedio Proceso >= 60, nota > 4
     *  [X] Asistencia por cargo >= 40
     *  [X] TFI >= 60, nota >=4
     */
    const ASISTENCIA_ACCREDITATION_DIRECTA = 75;
    const PROCESO_ACCREDITATION_DIRECTA = 60;
    const NOTA_PROCESO_ACCREDITATION_DIRECTA = 4;
    const PROMEDIO_ACCREDITATION_DIRECTA = 78;
    const NOTA_PROMEDIO_ACCREDITATION_DIRECTA = 7;
    const TFI_ACCREDITATION_DIRECTA = 78;
    const NOTA_TFI_ACCREDITATION_DIRECTA = 7;

    const ASISTENCIA_MIN_REGULAR = 60;
    const ASISTENCIA_MAX_REGULAR = 75;
    const ASISTENCIA_MIN_CARGO_REGULAR = 40;
    const ASISTENCIA_PRACTICA_PROFESIONAL = 100;


    const PROMEDIO_MIN_REGULAR = 60;
    const NOTA_PROMEDIO_MIN_REGULAR = 4;
    const PROMEDIO_MAX_REGULAR = 78;
    const NOTA_PROMEDIO_MAX_REGULAR = 7;
    const TFI_MIN_REGULAR = 60;
    const NOTA_TFI_MIN_REGULAR = 4;
    const TFI_MAX_REGULAR = 78;
    const NOTA_TFI_MAX_REGULAR = 4;

    const PERCENT_RAI = 70;

    const PERCENT_APROBADO = 60;
    const NOTA_PERCENT_APROBADO = 4;
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
     * Asocia los procesos son procesos modulares
     *
     * @param $materia_id <b>id</b> materia
     * @param int|null $ciclo_lectivo <b>ciclo lectivo</b>
     * @return void
     */
    public function crearProcesoModular(int $materia_id, int $ciclo_lectivo = null)
    {
        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        $pm_sin_vincular = $this->obtenerProcesosModularesNoVinculados($materia_id, $ciclo_lectivo);
        $inicio = 0;
        foreach ($pm_sin_vincular as $pm) {
            $data['proceso_id'] = $pm->id;
            $data['ciclo_lectivo'] = $pm->ciclo_lectivo;
            ProcesoModular::create($data);
            $inicio += 1;
        }

    }

    /**
     * @param int $materia_id <b>id</b> materia
     * @return mixed
     */
    public function obtenerProcesosModularesNoVinculados(int $materia_id, int $ciclo_lectivo = null)
    {
        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }


        $procesos = Proceso::select('procesos.id')
            ->where('materia_id', '=', $materia_id)
            ->where('ciclo_lectivo', '=', $ciclo_lectivo)
            ->get();


        return Proceso::select('procesos.id')
            ->where('procesos.materia_id', $materia_id)
            ->where('procesos.ciclo_lectivo', $ciclo_lectivo)
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
    public function obtenerProcesosModularesByMateria($materia_id, $ciclo_lectivo = null)
    {
        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        return ProcesoModular::select('proceso_modular.*')
            ->join('procesos', 'procesos.id', 'proceso_modular.proceso_id')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('procesos.ciclo_lectivo', $ciclo_lectivo)
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
     * @param null $ciclo_lectivo
     * @return int
     */
    public function cargarPonderacionEnProcesoModular(Materia $materia, $ciclo_lectivo = null): int
    {
        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        $this->crearProcesoModular($materia->id, $ciclo_lectivo);

        $procesoCalificacionService = new ProcesoCalificacionService();

        $serviceCargo = new CargoService();
        $serviceProcesoCalificacion = new ProcesoCalificacionService();
        $cant = 0;
        $cargos = $this->obtenerCargosPorModulo($materia);
        $promedio_final_p = 0;
        $procesos = $this->obtenerProcesosModularesByMateria($materia->id, $ciclo_lectivo);

        foreach ($procesos as $proceso) {
            $nota_final_p = 0;
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
//            $proceso->promedio_final_nota = $nota = $serviceProcesoCalificacion->calculoPorcentajeNota(
//                $promedio_final_p
//            );
            $proceso->promedio_final_nota = $this->revisaNotasProceso($materia, $proceso->procesoRelacionado()->first());

            if (!$proceso->trabajo_final_porcentaje) {
                if ($cargo->responsableTFI($materia->id)) {
                    $tfp = $procesoCalificacionService->obtenerProcesoCalificacionByProcesoMateriaCargoTipo(
                        $proceso->procesoRelacionado()->first()->id,
                        $materia->id,
                        $cargo->id,
                        CalificacionService::TIPO_TFI
                    )->first();
                    if ($tfp) {
                        $proceso->trabajo_final_porcentaje = $tfp->porcentaje;
                        $proceso->trabajo_final_nota = $tfp->nota;
                    }
                }
            }

            $proceso->nota_final_porcentaje = $proceso->trabajo_final_porcentaje * 0.2 + $proceso->promedio_final_porcentaje * 0.8;
//            $proceso->nota_final_nota = $proceso->trabajo_final_nota * 0.2 + $proceso->promedio_final_nota * 0.8;
            $proceso->nota_final_nota = $proceso->trabajo_final_nota * 0.2 + $proceso->promedio_final_nota * 0.8;

//            $proceso->porcentaje_actividades_aprobado = $this->obtenerPorcentajeProcesoAprobado(
//                $proceso->procesoRelacionado()->first()->id,
//                $materia->id,
//                $cargo->id,
//            );
//            print_r('-- ');
//print_r($proceso->porcentaje_actividades_aprobado);
            $proceso->update();

            $cant += 1;

        }
        $this->grabaEstadoCursoEnModulo($materia->id, $ciclo_lectivo);

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
     * @param $ciclo_lectivo
     * @return string[] <i>200</i> si generó todos los estados
     */
    public function grabaEstadoCursoEnModulo($materia_id, $ciclo_lectivo): array
    {

        $estados_procesados = [];

        $procesosModulares = $this->obtenerProcesosModularesByMateria($materia_id, $ciclo_lectivo);


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
            $this->getCalificacionModularBoolean(self::NOTA_PROCESO_ACCREDITATION_DIRECTA, $proceso)
            and
            $this->getPromedioModularBoolean(self::NOTA_PROMEDIO_ACCREDITATION_DIRECTA, $pm->promedio_final_nota)
            and
            $this->getTFIModularBoolean(self::NOTA_TFI_ACCREDITATION_DIRECTA, $pm->trabajo_final_nota)
            and
            $this->getActividadesAprobadosBool(self::PERCENT_RAI, $pm->porcentaje_actividades_aprobado)
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
            $this->getCalificacionModularBoolean(self::NOTA_PROMEDIO_MIN_REGULAR, $proceso)
            and
            $this->getTFIModularBoolean(self::NOTA_TFI_MIN_REGULAR, $pm->promedio_final_nota)
            and
            $this->getActividadesAprobadosBool(self::PERCENT_RAI, $pm->porcentaje_actividades_aprobado)
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
    public function getCalificacionModularBoolean(int $nota, Proceso $proceso): bool
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
            if ($nota > $this->processProceso(
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
     * @param int $nota_max
     * @param float $nota_final
     * @return bool
     */
    public function getPromedioModularBoolean(int $nota_max, float $nota_final): bool
    {
        return $nota_final >= self::NOTA_PROMEDIO_ACCREDITATION_DIRECTA;
    }

    /**
     * @param int $nota_max
     * @param int|null $trabajo_final_nota
     * @return bool
     */
    public function getTFIModularBoolean(int $nota_max, int $trabajo_final_nota = null): bool
    {
        if (!$trabajo_final_nota) {
            return false;
        }

        return $trabajo_final_nota >= $nota_max;
    }

    /**
     * @param int $nota_para_aprobar
     * @param float|null $nota_obtenida
     * @return bool
     */
    public function getActividadesAprobadosBool(int $nota_para_aprobar, float $nota_obtenida = null): bool
    {
        if (!$nota_obtenida) {
            return false;
        }

        return $nota_para_aprobar >= $nota_obtenida;
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
            if (is_numeric($parcial->nota)) {
                $pp = $parcial->nota;
            }
            if (is_numeric($parcial->nota_recuperatorio)) {
                $ppr = $parcial->nota_recuperatorio;
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

    /**
     * @param $proceso
     * @param $materia
     * @param $cargo
     * @param $ciclo_lectivo
     * @return float
     */
    public function obtenerPorcentajeProcesoAprobado($proceso, $materia, $cargo, $ciclo_lectivo): float
    {
        // Llamo a los servicios de procesos y calificaciones
        $pCS = new ProcesoCalificacionService();
        $calificacionService = new CalificacionService();

        // Inicializo las variables
        $total_aprobados = 0;
        $porcentaje_aprobado = 0;

        // cuento los parciales
        $total_parciales = $calificacionService->cuentaCalificacionesByMateriaCargoTipo(
            $materia,
            $cargo,
            CalificacionService::TIPO_PARCIAL,
            $ciclo_lectivo
        );
        // cuento los trabajos prácticos
        $total_tps = $calificacionService->cuentaCalificacionesByMateriaCargoTipo(
            $materia,
            $cargo,
            CalificacionService::TIPO_TP,
            $ciclo_lectivo
        );
        // sumo las actividades del cargo
        $total_actividades = $total_parciales + $total_tps;

        //Obtengo los parciales
        $parciales = $pCS->
        obtenerProcesoCalificacionByProcesoMateriaCargoTipo(
            $proceso,
            $materia,
            $cargo,
            CalificacionService::TIPO_PARCIAL,
            $ciclo_lectivo
        );
        //Obtengo los trabajos prácticos
        $tps = $pCS->
        obtenerNotaProcesoCalificacionByProcesoMateriaCargoTipo(
            $proceso,
            $materia,
            $cargo,
            CalificacionService::TIPO_TP,
            $ciclo_lectivo
        )->pluck('nota');

        // Calculo parciales aprobados
        foreach ($parciales as $parcial) {
            // Inicio las variables
            $pp = 0;
            $ppr = 0;
            //busco la nota del parcial si existe
            if (is_numeric($parcial->nota)) {
                $pp = $parcial->nota;
            }
            //busco la nota del recuperatorio si existe
            if (is_numeric($parcial->nota_recuperatorio)) {
                $ppr = $parcial->nota_recuperatorio;
            }
            // Busco la nota mayor entre parcial y recuperatorio
            $total_p = max($pp, $ppr);

            // Sumo parcial aprobado si fuere el caso
            if ($total_p >= self::NOTA_PERCENT_APROBADO) {
                $total_aprobados++;
            }
        }

        //calculo trabajos prácticos aprobados
        foreach ($tps as $tp) {
            // Aseguro nota positiva ante posible ausente (-1)
            $total_tp = max($tp, 0);
            // Sumo aprobado si fuere el caso
            if ($total_tp >= self::NOTA_PERCENT_APROBADO) {
                $total_aprobados++;
            }
        }

        // Calculo porcentaje de aprobados evitando división por cero
        if ($total_actividades > 0) {
            $porcentaje_aprobado = $total_aprobados * 100 / $total_actividades;
        }

        return $porcentaje_aprobado;
    }

    public function esAprobadoRai($proceso, $materia, $cargo): bool
    {
        return self::PERCENT_RAI >= $this->obtenerPorcentajeProcesoAprobado($proceso, $materia, $cargo);
    }

    /**
     * @param Materia $materia
     * @param Proceso $proceso
     * @return float|int
     */
    public function revisaNotasProceso(Materia $materia, Proceso $proceso)
    {
        $materia->cargos();

        $cargos = $materia->cargos()->get()->pluck('id');
        $calificacionService = new CalificacionService();


        $total_modulo = 0;
        foreach ($materia->cargos()->get() as $cargo) {
            $total_cargo = $this->getTotalCargo($cargo, $materia, $proceso);

            $total_modulo += $total_cargo;
        }

        return $total_modulo;

    }

    /**
     * @param ProcesoCalificacionService $procesoCalificacionService
     * @param $calificaciones
     * @param Proceso $proceso
     * @param $weighing
     * @return array
     */
    protected function obtenerNotaPonderadaTps(
                                   $calificaciones,
        Proceso                    $proceso,
                                   $weighing
    ): array
    {
        $procesoCalificacionService = new ProcesoCalificacionService();
        $notaCalificacion = $procesoCalificacionService->obtenerNotaProcesoCalificacion(
            $calificaciones,
            $proceso->id
        )->pluck('nota')->toArray();

        $suma = array_sum($notaCalificacion);

        $cuenta = count($notaCalificacion);
        $promedio = 0;
        if ($cuenta > 0) {
            $promedio = $suma / $cuenta;
        }
        $total = $weighing / 100 * $promedio;

        return [
            'cuenta' => $cuenta,
            'suma' => $suma,
            'total' => $total,
        ];
    }

    protected function obtenerNotaPonderadaParciales(
        $calificaciones,
        Proceso $proceso,
        int $weighing
    ): array
    {

        $procesoCalificacionService = new ProcesoCalificacionService();
        $notaCalificacion = $procesoCalificacionService->obtenerNotaProcesoCalificacion(
            $calificaciones,
            $proceso->id
        );

        $cuenta = count($notaCalificacion);

        $total_p = 0;
        foreach ($notaCalificacion as $parcial) {

            $pp = 0;
            $ppr = 0;
            if (is_numeric($parcial->nota)) {
                $pp = $parcial->nota;
            }
            if (is_numeric($parcial->nota_recuperatorio)) {
                $ppr = $parcial->nota_recuperatorio;
            }

            $total_p += max($pp, $ppr);

        }


        $suma = $total_p;


        $promedio = 0;
        if ($cuenta > 0) {
            $promedio = $suma / $cuenta;
        }
        $total = $weighing / 100 * $promedio;

        return [
            'cuenta' => $cuenta,
            'suma' => $suma,
            'total' => $total,
        ];
    }


    public function setNotaProceso($proceso, $nota)
    {
        $procesoModular = ProcesoModular::where([
            'proceso_id' => $proceso
        ])->first();

        $procesoModular->promedio_final_nota = $nota;

        $procesoModular->update();

    }

    /**
     * @param $cargo
     * @param Materia $materia
     * @param Proceso $proceso
     * @return float|int
     */
    public function getTotalCargo($cargo, Materia $materia, Proceso $proceso)
    {
        $calificacionService = new CalificacionService();
        $weighing = $cargo->ponderacion($materia->id);
        // Busco solo los parciales
        $calificaciones_parcial = $calificacionService->calificacionesInCargos([$cargo->id],
            $proceso->ciclo_lectivo,
            [1])->pluck('id');

        $parcial = $this->obtenerNotaPonderadaParciales(
            $calificaciones_parcial,
            $proceso,
            $weighing
        );

        // Busco solo los tps
        $calificaciones_tps = $calificacionService->calificacionesInCargos([$cargo->id],
            $proceso->ciclo_lectivo,
            [2])->pluck('id');
        $tps = $this->obtenerNotaPonderadaTps(
            $calificaciones_tps,
            $proceso,
            $weighing
        );

        $configuration = Configuration::first();
        $total_cargo = 0;
        if ($configuration->value_parcial != null) {
            $value_parcial = $configuration->value_parcial / 100;

            $total_cargo = $tps['total'] * (1 - $value_parcial) + $parcial['total'] * $value_parcial;
        } else {
            $cuenta = $tps['cuenta'] + $parcial['cuenta'];
            $suma = $tps['suma'] + $parcial['suma'];
            if ($cuenta > 0) {
                $total_cargo = $weighing / 100 * $suma / $cuenta;
            }
        }
        return $total_cargo;
    }


}
