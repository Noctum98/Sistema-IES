<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCalificacion extends Model
{
    use HasFactory;
    protected $table = 'tipo_calificaciones';

    protected $fillable = [
        'descripcion',
        'nombre',
    ];
}
