<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoProceso extends Model
{
    use HasFactory;

    protected $table = 'cargo_procesos';
    protected $fillable = [
        'user_id',
        'cargo_id',
        'proceso_id',
        'ciclo_lectivo',
        'cantidad_tp',
        'suma_tp',
        'nota_tp',
        'cantidad_ps',
        'suma_ps',
        'nota_ps',
        'nota_cargo',
        'nota_ponderada'
    ];
}