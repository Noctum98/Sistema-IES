<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriasCorrelativa extends Model
{
    use HasFactory;

    protected $fillable = [
        'materia_id',
        'correlativa_id',
        'operador_id',
    ];



}
