<?php

namespace App\Services\Mesas;

use App\Models\Carrera;
use App\Models\Sede;

class InstanciaService
{
    public function agregarSedes($request,$instancia)
    {
        $instancia->sedes()->detach();
        foreach($request['sedes'] as $sede_id)
        {
            $instancia->sedes()->attach(Sede::find($sede_id));
        }
    }

    public function agregarCarreras($request,$instancia)
    {   
        $instancia->carreras()->detach();
        foreach($request['carreras'] as $carrera_id)
        {
            $instancia->carreras()->attach(Carrera::find($carrera_id));
        }
    }
}