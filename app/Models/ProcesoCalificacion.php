<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcesoCalificacion extends Model
{
    use HasFactory;

    protected $table = "proceso_calificacion";
    protected $fillable = [
        'proceso_id',
        'calificacion_id',
        'nota',
        'porcentaje',
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
