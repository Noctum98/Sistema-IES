<?php

namespace App\Services\Mesas;

use App\Models\Carrera;
use App\Models\Sede;
use Carbon\Carbon;

class InstanciaService
{

    public function verifyCierres($instancia)
    {
        $fechaActual = Carbon::now(); // Obtiene la fecha y hora actual
        $data = [
            'estado' => 'inactiva',
            'cierre' => true
        ];

        if ($instancia->fecha_habilitiacion) {

            if ($instancia->tipo == 0) {
                if (Carbon::parse($instancia->fecha_habilitiacion)->lte($fechaActual) && Carbon::parse($instancia->fecha_cierre)->gte($fechaActual)) {
                    $data['estado'] = 'activa';
                }
            } else {
                if (Carbon::parse($instancia->fecha_habilitiacion)->lte($fechaActual) && Carbon::parse($instancia->fecha_cierre)->gte($fechaActual)) {
                    $data['estado'] = 'activa';
                }

                // Verificar si está en bajas
                if (Carbon::parse($instancia->fecha_bajas)->lte($fechaActual) && Carbon::parse($instancia->fecha_cierre_bajas)->gte($fechaActual)) {
                    $data['cierre'] = false;
                    $data['estado'] = 'activa';
                }

                if ($fechaActual->gte(Carbon::parse($instancia->fecha_cierre_bajas))) {
                    $data['estado'] = 'inactiva';
                    $data['cierre'] = true;
                }
            }

            if ($instancia->estado != $data['estado'] || $instancia->cierre != $data['cierre']) {
                $instancia->update($data);
            }
        }


        return $instancia;
    }
    public function agregarSedes($request, $instancia)
    {
        $instancia->sedes()->detach();
        foreach ($request['sedes'] as $sede_id) {
            $instancia->sedes()->attach(Sede::find($sede_id));
        }
    }

    public function agregarCarreras($request, $instancia)
    {
        $instancia->carreras()->detach();
        foreach ($request['carreras'] as $carrera_id) {
            $instancia->carreras()->attach(Carrera::find($carrera_id));
        }
    }
}
