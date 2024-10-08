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

    public function instancia(): BelongsTo
    {
        return $this->belongsTo(Instancia::class, 'instancia_id');
    }

    public function getLibro(): BelongsTo
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }

    /**
     * @param int $sede_id
     * @return ActaVolante[]
     */
    public function getActasVolantesBySede(int $sede_id): array
    {
        return  self::whereHas('mesa.materia.carrera.sede', static function ($query) use($sede_id) {
            $query->where('id', $sede_id);
        })->get();
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}
