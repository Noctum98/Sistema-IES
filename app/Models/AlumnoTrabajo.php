<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoTrabajo extends Model
{
    use HasFactory;
    protected $table = 'alumno_trabajo';

    public function alumno(){
        return $this->belongsTo('App\Models\Alumno','alumno_id');
    }
}
