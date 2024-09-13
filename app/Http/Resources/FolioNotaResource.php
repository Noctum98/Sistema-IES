<?php

namespace App\Http\Resources;

use App\Models\FolioNota;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FolioNota */
class FolioNotaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'orden' => $this->orden,
            'permiso' => $this->permiso,
            'escrito' => $this->escrito,
            'oral' => $this->oral,
            'definitiva' => $this->definitiva,

            'user_id' => $this->user_id,
            'acta_volante_id' => $this->acta_volante_id,
            'mesa_folio_id' => $this->mesa_folio_id,
            'alumno_id' => $this->alumno_id,

            'mesaFolio' => new MesaFolioResource($this->whenLoaded('mesaFolio')),
        ];
    }
}
