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
//            ->dd()
        ;
    }

}