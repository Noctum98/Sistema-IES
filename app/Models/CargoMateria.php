<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoMateria extends Model
{
    use HasFactory;
    protected $table = 'cargo_materia';
    protected $fillable = ['ponderacion'];


}
