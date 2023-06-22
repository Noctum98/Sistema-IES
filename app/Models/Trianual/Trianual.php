<?php

namespace App\Models\Trianual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trianual extends Model
{
    use HasFactory;

    protected $fillable = [
        'sede_id',
        'carrera_id',
        'cohorte',
        'resolucion',
        'alumno_id',
        'matricula',
        'libro',
        'folio',
        'operador_id',
        'promedio',
        'fecha_egreso',
        'preceptor',
        'coordinator'
    ];

    public function getObservaciones(): HasMany
    {
        return $this->hasMany(ObservacionesTrianual::class, 'trianual_id');
    }
}
