<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\OldLibro */
class OldLibroResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'acta_inicio' => $this->acta_inicio,
            'number' => $this->number,
            'fecha_inicio' => $this->fecha_inicio,
            'resolucion_original' => $this->resolucion_original,
            'observaciones' => $this->observaciones,

            'resoluciones_id' => $this->resoluciones_id,
            'sede_id' => $this->sede_id,
            'operador_id' => $this->operador_id,
            'user_id' => $this->user_id,

            'resoluciones' => new resolucionesResource($this->whenLoaded('resoluciones')),
        ];
    }
}
