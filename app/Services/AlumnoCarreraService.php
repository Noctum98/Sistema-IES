<?php

namespace App\Services;

use App\Models\AlumnoCarrera;

class AlumnoCarreraService
{
    public function datosInscripcion($request)
    {
        $inscripcion = AlumnoCarrera::where(['alumno_id' => $request['alumno_id'],'carrera_id' => $request['carrera_id']])
        ->orderBy('created_at', 'desc')
        ->first();

        $datos = [
            'alumno_id' => $inscripcion->alumno_id,
            'carrera_id' => $inscripcion->carrera_id,
            'año' => $request['año'],
            'fecha_primera_acreditacion' => $inscripcion->fecha_primera_acreditacion,
            'fecha_ultima_acreditacion' => $inscripcion->fecha_ultima_acreditacion,
            'cohorte' => $inscripcion->cohorte,
            'legajo_completo' => $inscripcion->legajo_completo,
            'ciclo_lectivo' => $request['ciclo_lectivo']
        ];

        return $datos;
    }
}