<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesaAlumno extends Model
{
    use HasFactory;
    protected $table = 'mesa_alumno';

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }
    public function mesa(){
        return $this->belongsTo('App\Models\Mesa','mesa_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');

    }

    // Funciones adicionales

    public function alumnoByDni($dni)
    {
        $alumno = Alumno::where('dni',$dni)->first();

        return $alumno;
    }
}
