<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Resoluciones */
class resolucionesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'duration' => $this->duration,
            'resolution' => $this->resolution,
            'type' => $this->type,
            'vaccines' => $this->vaccines,

            'estados_id' => $this->estados_id,
        ];
    }
}
