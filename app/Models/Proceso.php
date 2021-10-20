<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }
    public function alumno(){
        return $this->belongsTo('App\Models\Alumno','alumno_id');
    }
}
