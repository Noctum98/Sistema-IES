<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CondicionCarrera extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'nombre',
        'identificador',
        'habilitado',
    ];

    protected function operador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operador_id');
    }
}
