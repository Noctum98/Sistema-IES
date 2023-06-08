<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaHoraria extends Model
{
    use HasFactory;
    protected $fillable = [
      'profesor_id',
      'materia_id',
      'cantidad_horas',
      'usuario_id'
    ];

    protected $table = 'workloads';
}
