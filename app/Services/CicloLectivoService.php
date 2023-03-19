<?php

namespace App\Services;

class CicloLectivoService
{
    const CICLO_LECTIVO_INICIAL = 2022;


    /**
     * Devuelve un array con el ciclo lectivo de inicio y el ciclo lectivo actual
     * Ambos en entero de 4 dígitos
     * @return array
     */
    public function getCicloInicialYActual(): array
    {
        $last = self::CICLO_LECTIVO_INICIAL;
        $ahora = date('Y');

        return array($last, $ahora);
    }

}