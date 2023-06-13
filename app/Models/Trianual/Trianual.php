<?php

namespace App\Models\Trianual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trianual extends Model
{
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

    use HasFactory;
}
