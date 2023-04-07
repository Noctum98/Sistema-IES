<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcesoCalificacion extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "proceso_calificacion";
    protected $fillable = [
        'proceso_id',
        'calificacion_id',
        'nota',
        'porcentaje',
        'nota_recuperatorio',
        'porcentaje_recuperatorio',
        'close_profesor',
        'close_coordinador',
        'open_profesor',
        'open_coordinador',
        'close'
    ];

    public function calificacion(): BelongsTo
    {
        return $this->belongsTo(Calificacion::class, 'calificacion_id');
    }

}
