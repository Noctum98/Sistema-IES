<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActaVolante extends Model
{
    use HasFactory;
    protected $table = 'actas_volantes';
    protected $fillable = [
        'nota_escrito',
        'nota_oral',
        'promedio',
        'instancia_id',
        'mesa_id',
        'alumno_id',
        'materia_id',
        'mesa_alumno_id',
        'libro_id',
        'inscripcion_id'
    ];


    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(MesaAlumno::class,'mesa_alumno_id');
    }

    public function mesa(): BelongsTo
    {
        return $this->belongsTo(Mesa::class,'mesa_id');
    }
    public function mesaAlumno(): BelongsTo
    {
        return $this->belongsTo(MesaAlumno::class,'mesa_alumno_id');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class,'materia_id');
    }

    public function inscripcionCarrera(): BelongsTo
    {
        return $this->belongsTo(AlumnoCarrera::class,'inscripcion_id');
    }
}
