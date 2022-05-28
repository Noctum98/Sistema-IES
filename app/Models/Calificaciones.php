<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_id',
        'proceso_id',
        'nombre',
        'nota'
    ];

    public function tipoCalificaciones(): BelongsTo
    {
        return $this->belongsTo(TipoCalificaciones::class,'tipo_id');
    }

    public function proceso(): BelongsTo
    {
        return $this->belongsTo(Proceso::class,'proceso_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
