<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    public function sede(){
        return $this->belongsTo('App\Models\Sede','sede_id');
    }
    public function materias(){
        return $this->hasMany('App\Models\Materia')->orderBy('año');
    }
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class)->withTimestamps();
    }
}
