<?php

namespace App\Services;

use App\Models\Equivalencias;

class EquivalenciasService
{
    /**
     * @param int $alumno
     * @param int $materia
     * @return mixed
     */
    public function equivalenciaPorAlumnoMateria(int $alumno, int $materia)
    {
        return Equivalencias::where([
            'alumno_id' => $alumno,
            'materia_id' => $materia,
        ])
            ->orderBy('fecha', 'DESC')
            ->first();
    }
}
