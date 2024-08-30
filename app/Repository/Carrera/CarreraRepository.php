<?php

namespace App\Repository\Carrera;

use App\Models\Carrera;
use App\Models\Resoluciones;

class CarreraRepository
{
    public function getResolucionesBySede($sede_id)
    {
        $carreras = Carrera::where('sede_id', $sede_id)->get()->pluck('resolucion_id')->toArray();

        return Resoluciones::whereIn('id', $carreras)->select('id', 'name')->get();

    }

}
