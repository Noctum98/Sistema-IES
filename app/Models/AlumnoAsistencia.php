<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumnoAsistencia extends Model
{
    use HasFactory;
    protected $table = 'alumno_asistencia';

    public function alumno(): BelongsTo
    {
        return $this->belongsTo('App\Models\Alumno','alumno_id')->orderBy('apellidos');
    }
}
