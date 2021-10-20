<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    public function carrera(){
        return $this->belongsTo('App\Models\Carrera','carrera_id');
    }
    public function asistencias(){
        return $this->hasMany('App\Models\AlumnoAsistencia');
    }
}
