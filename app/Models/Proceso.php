<?php

namespace App\Models;

use App\Models\Proceso\EtapaCampo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proceso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'alumno_id',
        'materia_id',
        'estado_id',
        'cierre',
        'final_calificaciones',
        'porcentaje_final_calificaciones',
        'nota_global',
        'nota_recuperatorio',
        'operador_id',
        'cargo_id',
        'ciclo_lectivo',
        'habilitado_campo'
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo('App\Models\Materia', 'materia_id');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo('App\Models\Alumno', 'alumno_id')->withTrashed();
    }

    public function asistencia()
    {
        return Asistencia::where('proceso_id', $this->id)->first();
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'estado_id');
    }

    public function etapaCampo(): HasOne
    {
        return $this->hasOne(EtapaCampo::class, 'proceso_id');
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
        $procesosCalificaciones = ProcesoCalificacion::join('procesos', 'procesos.id', 'proceso_calificacion.proceso_id')
            ->join('alumnos', 'procesos.alumno_id', 'alumnos.id')
            ->join('calificaciones', 'calificaciones.id', 'proceso_calificacion.calificacion_id')
            ->where(
                ['proceso_id' => $this->id]
            )->where('calificaciones.tipo_id', 2)
            ->orderBy('calificacion_id', 'ASC')
            ->get();


        return $procesosCalificaciones;
    }

    public function calificacionTFI()
    {
        $calificacion_tfi = ProcesoCalificacion::join('calificaciones', 'calificaciones.id', 'proceso_calificacion.calificacion_id')
            ->where('proceso_id', $this->id)
            ->where('calificaciones.materia_id', $this->materia_id)
            ->where('calificaciones.tipo_id', 3)
            ->first();

        return $calificacion_tfi;
    }

    public function cargos()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function procesoModular()
    {
        return ProcesoModular::where(
            ['proceso_id' => $this->id])
            ->get();
    }

    public function obtenerProcesoCargo(int $cargo)
    {
        return ProcesosCargos::where([
            'cargo_id' => $cargo,
            'proceso_id' => $this->id
        ])->first();
    }

    public function obtenerRegularidad()
    {
        return Regularidad::where([
            'proceso_id' => $this->id
        ])
            ->first();
    }
}
