<?php

namespace App\Models\Trianual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acreditacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'detalle_trianual_id',
        'operador_id',
        'orden',
        'nota',
        'fecha_acreditacion',
        'libro',
        'folio',
        'excepcion',
        'mesa_id'
    ];


}
