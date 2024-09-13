<?php

namespace App\Http\Resources;

use App\Models\LibroPapel;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin LibroPapel */
class LibroPapelResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'roman' => $this->roman,
            'fecha_inicio' => $this->fecha_inicio,
            'acta_inicio' => $this->acta_inicio,
            'operador_inicio' => $this->operador_inicio,
            'sede_id' => $this->sede_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
