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
     * @return int
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

    public function obtenerProcesoCalificacionByProcesoMateriaCargoTipo($proceso, $materia, $cargo,$tipo)
    {
        $calificacionService = new CalificacionService();
        $calificaciones = $calificacionService->calificacionesByMateriaCargoTipo($materia, $cargo,$tipo)->pluck('id')->toArray();

        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->whereIn('proceso_calificacion.calificacion_id', $calificaciones)
            ->where('proceso_calificacion.proceso_id', $proceso)
            ->get();
    }

    public function cuentaProcesoCalificacionByProcesoMateriaCargoTipo($proceso, $materia, $cargo,$tipo): int
    {
        return count($this->obtenerProcesoCalificacionByProcesoMateriaCargoTipo($proceso, $materia, $cargo,$tipo));
    }


    public function obtenerNotaByProcesoTipoCalificacion($proceso, $calificacion)
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->where('proceso_calificacion.calificacion_id', $calificacion)
            ->where('proceso_calificacion.proceso_id', $proceso)
            ->first();
    }



}