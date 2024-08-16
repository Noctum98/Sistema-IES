<?php

namespace App\Services;

use App\Models\Materia;
use Illuminate\Support\Carbon;
use Illuminate\Support\HigherOrderCollectionProxy;

class CicloLectivoService
{
    const CICLO_LECTIVO_INICIAL = 2022;
    const DATES_CIERRE = 180;


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

    /**
     * @param Materia $materia
     * @param $ciclo_lectivo
     * @param int|null $dates
     * @return Carbon
     */
    public function getCierreDate(Materia $materia, $ciclo_lectivo, int $dates = null): Carbon
    {

        $days = self::DATES_CIERRE;

        if ($dates) {
            $days = $dates;
        }
        $cierre = null;

        //dd($ciclo_lectivo);

        if ($materia->getCierre($ciclo_lectivo)) {
            $cierre = Carbon::createFromFormat('Y-m-d', $materia->getCierre($ciclo_lectivo));
        }

        if (!$cierre) {
            $cierre = now();
        }

        return $cierre->addDays($days);

    }


    /**
     * @param Materia $materia
     * @param $ciclo_lectivo
     * @param Carbon $dates
     * @param int|null $daysTop
     * @return bool
     */
    public function getCierreBoolean($materia, $ciclo_lectivo, Carbon $dates, int $daysTop = null): bool
    {

        if (!$daysTop) {
            $daysTop = self::DATES_CIERRE;
        }
        $fechaFin = $this->getCierreDate($materia, $ciclo_lectivo, $daysTop);


        return $dates->gte($fechaFin);


    }


}
