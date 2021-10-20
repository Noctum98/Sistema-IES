<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoAsistencia extends Model
{
    use HasFactory;
    protected $table = 'alumno_asistencia';

    public function alumno(){
        return $this->belongsTo('App\Models\Alumno','alumno_id')->orderBy('apellidos');
    }
}
