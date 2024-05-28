<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\AgrupadaMateria */
class AgrupadaMateriaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'disabled' => $this->disabled,

            'correlatividad_agrupada_id' => $this->correlatividad_agrupada_id,
            'master_materia_id' => $this->master_materia_id,
            'user_id' => $this->user_id,

            'correlatividadAgrupada' => new CorrelatividadAgrupadaResource($this->whenLoaded('correlatividadAgrupada')),
            'masterMateria' => new MasterMateriaResource($this->whenLoaded('masterMateria')),
        ];
    }
}
