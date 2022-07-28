<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proceso extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'materia_id',
        'estado_id',
        'cierre',
        'porcentaje_final_calificaciones',
        'nota_global',
        'nota_recuperatorio',
        'operador_id',
        'cargo_id'
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo('App\Models\Materia', 'materia_id');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo('App\Models\Alumno', 'alumno_id');
    }

    public function asistencia()
    {
        $asistencia = Asistencia::where('proceso_id', $this->id)->first();

        return $asistencia;
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class,'estado_id');
    }

    public function procesoCalificacion($calificacion_id)
    {
        $procesoCalificacion = ProcesoCalificacion::where(
            ['proceso_id' => $this->id, 'calificacion_id' => $calificacion_id]
        )->first();

        return $procesoCalificacion;
    }

    public function procesosCalificaciones()
    {
        $procesosCalificaciones = ProcesoCalificacion::where(
            ['proceso_id' => $this->id]
        )
            ->orderBy('calificacion_id', 'ASC')
            ->get()
        ;

        return $procesosCalificaciones;
    }

    public function cargos()
    {
        return $this->belongsTo(Cargo::class,'cargo_id');
    }
}
