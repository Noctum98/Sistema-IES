<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} =  Uuid::uuid4()->toString();
        });
    }
}
