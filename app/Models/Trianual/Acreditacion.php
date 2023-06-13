<?php

namespace App\Models\Trianual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acreditacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'detalle_id',
        'operador_id',
        'nota',
        'fecha_acreditacion',
        'libro',
        'folio',
        'excepcion'
    ];
}
