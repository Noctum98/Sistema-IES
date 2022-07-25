<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Proceso;


class ProcesoCalificacionService
{

    public function calculoPorcentajeNota(int $porcentaje)
    {

        $nota = 0;
        switch ($porcentaje) {
            case ($porcentaje >= 1 && $porcentaje <= 19):
                $nota = 1;
                break;
            case ($porcentaje >= 20 && $porcentaje <= 39):
                $nota = 2;
                break;
            case ($porcentaje >= 40 && $porcentaje <= 59):
                $nota = 3;
                break;
            case ($porcentaje >= 60 && $porcentaje <= 65):
                $nota = 4;
                break;
            case ($porcentaje >= 66 && $porcentaje <= 71):
                $nota = 5;
                break;
            case ($porcentaje >= 72 && $porcentaje <= 77) :
                $nota = 6;
                break;
            case ($porcentaje >= 78 && $porcentaje <= 83) :
                $nota = 7;
                break;
            case ($porcentaje >= 84 && $porcentaje <= 89) :
                $nota = 8;
                break;
            case ($porcentaje >= 90 && $porcentaje <= 95) :
                $nota = 9;
                break;
            case ($porcentaje >= 96 && $porcentaje <= 100) :
                $nota = 10;
        }

        return $nota;

    }
}