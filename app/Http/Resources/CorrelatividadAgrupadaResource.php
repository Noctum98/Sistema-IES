<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\CorrelatividadAgrupada */
class CorrelatividadAgrupadaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'Name' => $this->Name,
            'Description' => $this->Description,
            'Identifier' => $this->Identifier,

            'resoluciones_id' => $this->resoluciones_id,
            'user_id' => $this->user_id,

            'resoluciones' => new resolucionesResource($this->whenLoaded('resoluciones')),
        ];
    }
}
