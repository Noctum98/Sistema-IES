<?php

namespace App\Models\Trianual;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    /**
     * @return Model|BelongsTo|object|null
     */
    public function getAlumno()
    {
        return $this->belongsTo(Alumno::class,'alumno_id', 'id')->first();
    }
    public function getCarrera()
    {
        return $this->belongsTo(Carrera::class,'carrera_id', 'id')->first();
    }
    public function getOperador($id)
    {
        return User::find($id);
    }
}
