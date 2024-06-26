<?php

namespace App\Http\Resources;

use App\Models\MesaFolio;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MesaFolio */
class MesaFolioResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'numero' => $this->numero,
            'turno' => $this->turno,
            'fecha' => $this->fecha,
            'aprobados' => $this->aprobados,
            'desaprobados' => $this->desaprobados,
            'ausentes' => $this->ausentes,
            'libro_digital_id' => $this->libro_digital_id,
            'mesa_id' => $this->mesa_id,
            'master_materia_id' => $this->master_materia_id,
            'presidente_id' => $this->presidente_id,
            'vocal_1_id' => $this->vocal_1_id,
            'vocal_2_id' => $this->vocal_2_id,
            'coordinador_id' => $this->coordinador_id,
            'operador_id' => $this->operador_id,

            'libroDigital' => new LibroDigitalResource($this->whenLoaded('libroDigital')),
        ];
    }
}
