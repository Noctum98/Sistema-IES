<?php

namespace App\Services;

use App\Models\ProcesoCalificacion;

class CalificacionService
{
    public function calificacionesByAlumno($alumno_id, $calificacion_id)
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->join('procesos', 'procesos.id', 'proceso_calificacion.proceso_id')
            ->where('proceso_calificacion.calificacion_id', $calificacion_id)
            ->where('procesos.alumno_id', $alumno_id)
            ->get()
        ;
    }

    public function calificacionParcialByAlumno($alumno_id, $calificacion_id)
    {
        $proceso_calificacion = $this->calificacionesByAlumno($alumno_id, $calificacion_id);
        $pp = $proceso_calificacion?$proceso_calificacion[0]->porcentaje:0;
        $pr = $proceso_calificacion?$proceso_calificacion[0]->porcentaje_recuperatorio:0;
        return max($pp, $pr);
    }

}