<?php

namespace App\Services;

use App\Models\Estados;

class EstadosService
{
    public function establecerEstadoModular($proceso)
    {

    }

    /**
     * @param int|null $estado
     * @return null|string
     */
    public function getEstadoById(int $estado = null): ?string
    {


        if (!$estado) {
            return null;
        }

        $estado = Estados::select(
            'estados.nombre'
        )
            ->where('estados.id', $estado)
            ->first();
        return $estado->nombre;

    }

}
