<?php

namespace App\Http\Resources;

use App\Models\Library;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Library */
class LibraryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->link,
        ];
    }
}
