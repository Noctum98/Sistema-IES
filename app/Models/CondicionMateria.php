<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CondicionMateria extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'identificador',
        'habilitado',
        'operador_id'
    ];

    protected function operador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operador_id');
    }
}
