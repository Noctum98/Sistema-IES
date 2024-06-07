<?php

namespace App\Http\Resources;

use App\Models\AdminManager;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AdminManager */
class AdminManagerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'model' => $this->model,
            'name' => $this->name,
            'link' => $this->link,
            'enabled' => $this->enabled,
            'icon' => $this->icon,
        ];
    }
}
