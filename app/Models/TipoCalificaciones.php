<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCalificaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'identificador',
        'nombre',
    ];
}
