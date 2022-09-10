<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoMateria extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'tipo_materias';

    protected $fillable = [
        'nombre',
        'identificador',
        'user_action_id'
    ];
}
