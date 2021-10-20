<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }

    public function trabajos(){
        return $this->hasMany('App\Models\AlumnoTrabajo');
    }
}
