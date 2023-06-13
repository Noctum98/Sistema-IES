<?php

namespace App\Models\Trianual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTrianual extends Model
{
    use HasFactory;

    protected $fillable = [
        'trianual_id',
        'materia_id',
        'condicion_id',
        'equivalencia_id',
        'proceso_id',
        'operador_id',
        'recursado',
    ];
}
