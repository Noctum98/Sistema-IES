<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equivalencias extends Model
{
    use HasFactory;
    protected $table = 'equivalencias';
    protected $fillable = ['alumno_id', 'materia_id', 'nota', 'fecha', 'resolution', 'user_id'];
}
