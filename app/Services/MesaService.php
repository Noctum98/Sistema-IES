<?php

namespace App\Services;

class MesaService
{
    public function verificarInscripcionesEspeciales($inscripciones,$materia,$instancia)
    {
        if(count($materia->mesas_instancias($instancia->id)) == 1)
        {
            $mesa = $materia->mesa($instancia->id);

            foreach($inscripciones as $inscripcion)
            {
                $inscripcion->update(['mesa_id'=>$mesa->id,'segundo_llamado'=> 0]);
            }
        }

        return $mesa;
    }
}