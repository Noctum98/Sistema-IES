<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'user_id',
        'cargo_id',
        'tipo_id',
        'materia_id',
        'nombre',
        'fecha',
        'ciclo_lectivo',
        'comision_id'
    ];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoCalificacion::class,'tipo_id');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class,'materia_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class,'user_id');
    }
    public function comision(): BelongsTo
    {
        return $this->belongsTo(Comision::class,'comision_id');
    }

    public function proceso(){
        return $this->belongsToMany(ProcesoCalificacion::class,'procesos')
            ->withPivot('proceso_id','calificacion_id');
    }

}
