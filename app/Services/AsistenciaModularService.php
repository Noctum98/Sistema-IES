<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\AsistenciaModular;
use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesoCalificacion;
use App\Models\ProcesoModular;


class AsistenciaModularService
{

    /**
     * @param $materia_id <b>id</b> materia
     * @return void
     */
    public function crearAsistenciaModular(int $materia_id)
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
     * @param $materia_id <b>id</b> de la materia
     * @return mixed
     */
    public function obtenerAsistenciasModularesByMateria($materia_id)
    {
        return AsistenciaModular::select('asistencias_modulares.*')
            ->join('asistencias', 'asistencias.id', 'asistencias_modulares.asistencia_id')
            ->join('procesos', 'procesos.id', 'asistencias.proceso_id')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->orderBy('alumnos.apellidos', 'asc')
            ->get();
    }

    public function calcularAsistencias(Materia $materia)
    {
        $total = 1;
        $cargos = $this->obtenerCargosPorModulo($materia);
        if ($cargos and count($cargos) > 0) {
            $total = count($cargos);
        }
        return 100 / $total;
    }


    public function cargarPonderacionEnAsistenciaModular(Materia $materia, $ciclo_lectivo): int
    {
        $serviceCargo = new CargoService();
        $serviceProcesoCalificacion = new ProcesoCalificacionService();
        $serviceProcesoModular = new ProcesoModularService();
        $cant = 0;
        $cargos = $this->obtenerCargosPorModulo($materia);
        $procesos = $serviceProcesoModular->obtenerProcesosModularesByMateria($materia->id, $ciclo_lectivo);
        foreach ($procesos as $proceso) {
            $this->calculateFinalAsistenciaModularPercentage($materia, $proceso);

            $cant += 1;

        }

        return $cant;

    }

    public function obtenerCargosPorModulo(Materia $modulo)
    {
        return $modulo->cargos()->get();
    }

    public function obtenerTimeUltimaCalificacion($materia_id)
    {
        $serviceProcesoCalificacion = new ProcesoCalificacionService();
        return $serviceProcesoCalificacion->obtenerTimeUltimaCalificacionPorModulo($materia_id);
    }

    public function obtenerTimeUltimoProcesoModular($materia_id)
    {
        return ProcesoModular::select('proceso_modular.updated_at')
            ->join('procesos', 'procesos.id', 'proceso_modular.proceso_id')
            ->where('procesos.materia_id', $materia_id)
            ->orderBy('proceso_modular.updated_at', 'desc')
            ->first();
    }

    /**
     * Obtiene el porcentaje de asistencia por cargo
     * Por ponderación o por simple promedio
     * @param Materia $materia
     * @param Cargo $cargo
     * @return float|int
     */
    public function getPorcentajeCargoAsistencia(Materia $materia, Cargo $cargo)
    {
        $pondera = $materia->asistencia_ponderada;
        if ($pondera == 0) {
            $cantidadCargos = count($materia->cargos()->get());
            return 100 / $cantidadCargos;
        }
        return $cargo->ponderacion($materia->id);
    }

    /**
     * @param Materia $materia
     * @param ProcesoModular $proceso
     * @return void
     */
    public function calculateFinalAsistenciaModularPercentage(
        Materia $materia, ProcesoModular $proceso): void
    {
        $asistencia_final_p = 0;

        $cargos = $this->obtenerCargosPorModulo($materia);
        foreach ($cargos as $cargo) {
            /** @var ProcesoModular $proceso */
            $ponderacion_cargo = $cargo->ponderacion($materia->id);

            /**
             * Aquí tengo que calcular la ponderación de la asistencia por asistencia modular
             * La relación es proceso→asistencia(proceso_id)→asistencia_modular(asistencia_id)
             * filtrando por cargo
             */

            if ($proceso->procesoRelacionado()->first()
                && $proceso->procesoRelacionado()->first()->asistencia()
                && $proceso->procesoRelacionado()->first()->asistencia()
                    ->getByAsistenciaCargo($cargo->id)) {
                $asistencia_cargo = $proceso->procesoRelacionado()->first()
                    ->asistencia()->getByAsistenciaCargo(
                        $cargo->id
                    )->porcentaje;
                $asistencia_final_p += $asistencia_cargo * $ponderacion_cargo / 100;
            }
        }

        $proceso->asistencia_final_porcentaje = round($asistencia_final_p, 0);
        $proceso->update();
    }

}
