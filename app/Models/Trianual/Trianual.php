<?php

namespace App\Models\Trianual;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function getDetalle(): HasMany
    {
        return $this->hasMany(DetalleTrianual::class, 'trianual_id');
    }
    public function getAlumno(): HasOne
    {
        return $this->hasOne(Alumno::class, 'alumno_id');
    }
}
