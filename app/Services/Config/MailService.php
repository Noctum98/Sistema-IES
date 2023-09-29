<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MailService
{
    public function guardarMotivoMesas($datos)
    {
        if($datos['tipo'] == 'Baja Mesas')
        {
            $datos['contenido'] = $datos['instancia']['nombre'];

            foreach($datos['motivos'] as $motivo)
            {
                $datos['contenido'] = $datos['']
            }
        }
    }
}