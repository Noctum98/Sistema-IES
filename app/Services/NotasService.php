<?php

namespace App\Services;

use App\Models\Nota;

class NotasService
{
    /**
     * @param int $ciclo_lectivo
     * @return int
     */
    public function getNotaSesenta(int $ciclo_lectivo): int
    {
        return $this->getNotasByCicloLectivo($ciclo_lectivo, 60)->valor;
    }

    /**
     * @param int $ciclo_lectivo
     * @param int $porcentaje
     * @return Nota
     */
    private function getNotasByCicloLectivo(int $ciclo_lectivo, int $porcentaje): Nota
    {
        return Nota::where('year','>=', $ciclo_lectivo)
            ->where('min','>=', $porcentaje)
            ->orderBy('min')
            ->first();
    }

}
