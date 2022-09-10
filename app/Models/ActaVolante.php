<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'materia_id'
    ];

}
