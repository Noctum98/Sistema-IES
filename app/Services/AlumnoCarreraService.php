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
            'alumno_id' => $request['alumno_id'],
            'carrera_id' => $request['carrera_id'],
            'año' => $request['año'],
            'ciclo_lectivo' => $request['ciclo_lectivo']
        ];

        if($inscripcion)
        {
            $datos['fecha_primera_acreditacion'] = $inscripcion->fecha_primera_acreditacion;
            $datos['fecha_ultima_acreditacion'] = $inscripcion->fecha_ultima_acreditacion;
            $datos['cohorte'] = $inscripcion->cohorte;
            $datos['legajo_completo'] = $inscripcion->legajo_completo;
        }

        return $datos;
    }
}