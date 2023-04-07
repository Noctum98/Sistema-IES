<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Proceso;
use App\Models\ProcesoCalificacion;


class ProcesoCalificacionService
{

    /**
     * Calcula la nota desde un porcentaje dado
     * @param int $porcentaje
     * @return int nota
     */
    public function calculoPorcentajeNota(int $porcentaje): int
    {

        $nota = 0;
        switch ($porcentaje) {
            case ($porcentaje >= 1 && $porcentaje <= 19):
                $nota = 1;
                break;
            case ($porcentaje >= 20 && $porcentaje <= 39):
                $nota = 2;
                break;
            case ($porcentaje >= 40 && $porcentaje <= 59):
                $nota = 3;
                break;
            case ($porcentaje >= 60 && $porcentaje <= 65):
                $nota = 4;
                break;
            case ($porcentaje >= 66 && $porcentaje <= 71):
                $nota = 5;
                break;
            case ($porcentaje >= 72 && $porcentaje <= 77) :
                $nota = 6;
                break;
            case ($porcentaje >= 78 && $porcentaje <= 83) :
                $nota = 7;
                break;
            case ($porcentaje >= 84 && $porcentaje <= 89) :
                $nota = 8;
                break;
            case ($porcentaje >= 90 && $porcentaje <= 95) :
                $nota = 9;
                break;
            case ($porcentaje >= 96 && $porcentaje <= 100) :
                $nota = 10;
                break;
        }

        return $nota;

    }

    /**
     * @param $materia
     * @return mixed
     */
    public function obtenerTimeUltimaCalificacionPorModulo($materia)
    {
         return ProcesoCalificacion::select('proceso_calificacion.updated_at')
            ->join('procesos', 'procesos.id', 'proceso_calificacion.proceso_id')
            ->where('procesos.materia_id', $materia)
            ->orderBy('proceso_calificacion.updated_at', 'desc')
            ->first();
    }

    /**
     * Obtengo procesos de calificación
     * proceso_id, calificacion_id, nota y porcentaje
     *
     * @param $proceso
     * @param $materia
     * @param $cargo
     * @param $tipo
     * @param null $ciclo_lectivo
     * @return mixed
     */
    public function obtenerProcesoCalificacionByProcesoMateriaCargoTipo($proceso, $materia, $cargo,$tipo, $ciclo_lectivo = null)
    {
        if(!$ciclo_lectivo){
            $ciclo_lectivo = date('Y');
        }
        $calificacionService = new CalificacionService();
        $calificaciones = $calificacionService->calificacionesByMateriaCargoTipo($materia, $cargo,$tipo, $ciclo_lectivo)->pluck('id')->toArray();

        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->whereIn('proceso_calificacion.calificacion_id', $calificaciones)
            ->where('proceso_calificacion.proceso_id', $proceso)
            ->get();
    }

    /**
     * Obtengo la nota de los procesos de calificación
     * nota
     *
     * @param $proceso
     * @param $materia
     * @param $cargo
     * @param $tipo
     * @param null $ciclo_lectivo
     * @return mixed
     */
    public function obtenerNotaProcesoCalificacionByProcesoMateriaCargoTipo($proceso, $materia, $cargo,$tipo, $ciclo_lectivo = null)
    {
        if(!$ciclo_lectivo){
            $ciclo_lectivo = date('Y');
        }
        $calificacionService = new CalificacionService();
        $calificaciones = $calificacionService->calificacionesByMateriaCargoTipo($materia, $cargo,$tipo, $ciclo_lectivo)->pluck('id')->toArray();

        return $this->obtenerNotaProcesoCalificacion($calificaciones, $proceso);
    }

    /**
     * Cuanto la cantidad de notas por proceso, según la calificación
     *
     * @param $proceso
     * @param $materia
     * @param $cargo
     * @param $tipo
     * @return int
     */
    public function cuentaProcesoCalificacionByProcesoMateriaCargoTipo($proceso, $materia, $cargo,$tipo): int
    {
        return count($this->obtenerProcesoCalificacionByProcesoMateriaCargoTipo($proceso, $materia, $cargo,$tipo));
    }



    /**
     * @param $calificaciones
     * @param $proceso
     * @return mixed
     */
    public function obtenerNotaProcesoCalificacion($calificaciones, $proceso)
    {
        return ProcesoCalificacion::select('proceso_calificacion.nota', 'proceso_calificacion.nota_recuperatorio')
            ->whereIn('proceso_calificacion.calificacion_id', $calificaciones)
            ->where('proceso_calificacion.proceso_id', $proceso)
            ->orderBy('proceso_calificacion.id', 'DESC')
            ->get()

//            ->dd()
            ;
    }

    public function obtenerNotaProcesoCalificacionModel($calificaciones, $proceso)
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->whereIn('proceso_calificacion.calificacion_id', $calificaciones)
            ->where('proceso_calificacion.proceso_id', $proceso)
            ->orderBy('proceso_calificacion.id', 'DESC')
            ->get()

//            ->dd()
            ;
    }


}
