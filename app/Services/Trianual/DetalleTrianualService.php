<?php

namespace App\Services\Trianual;

use App\Models\Trianual\DetalleTrianual;
use Illuminate\Database\Eloquent\Collection;


class DetalleTrianualService
{
    /**
     * @param int $trianual <i>id</i> del trianual
     */
    public function detallesPorTrianual(int $trianual)
    {
        return DetalleTrianual::select()
            ->join('materias', 'materias.id', 'detalle_trianuals.materia_id')
            ->where('detalle_trianuals.trianual_id', $trianual)
            ->orderBy('materias.año', 'ASC')
            ->orderBy('materias.nombre', 'ASC')
            ->orderBy('detalle_trianuals.recursado', 'ASC')
            ->get()
            ;
    }
}
