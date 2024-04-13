<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvisoRole extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'rol_id',
        'aviso_id'

    ];

    protected function aviso(): BelongsTo
    {
        return $this->belongsTo(Aviso::class);
    }

    protected function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }
}
