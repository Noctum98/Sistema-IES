<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    public function carrera(){
        return $this->belongsTo('App\Models\Carrera','carrera_id');
    }
     public function personal(){
        return $this->belongsTo('App\Models\Personal','personal_id');
    }
     public function correlativa(){
        return $this->belongsTo('App\Models\Materia','correlativa');
    }
    public function mesa_inscriptos(){
        return $this->hasMany('App\Models\MesaAlumno');
    }
    public function mesas(){
        return $this->hasMany('App\Models\Mesa');
    }
}
