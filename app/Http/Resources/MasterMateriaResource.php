<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\MasterMateria */
class MasterMateriaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'field_stage' => $this->field_stage,
            'delayed_closing' => $this->delayed_closing,

            'resoluciones_id' => $this->resoluciones_id,
            'regimen_id' => $this->regimen_id,

            'resoluciones' => new resolucionesResource($this->whenLoaded('resoluciones')),
            'regimen' => new RegimenResource($this->whenLoaded('regimen')),
        ];
    }
}
