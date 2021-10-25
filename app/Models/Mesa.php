<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }

    public function mesa_inscriptos(){
        return $this->hasMany('App\Models\MesaAlumno');
    }
}
