<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    public function carrera()
    {
        return $this->belongsTo('App\Models\Carrera', 'carrera_id');
    }

    public function cargos()
    {
        return $this->belongsToMany(Cargo::class)->withTimestamps();
    }

    public function personal()
    {
        return $this->belongsTo('App\Models\Personal', 'personal_id');
    }

    public function correlativa()
    {
        return $this->belongsTo('App\Models\Materia', 'correlativa');
    }

    public function mesa_inscriptos()
    {
        return $this->hasMany('App\Models\MesaAlumno');
    }

    public function mesas()
    {
        return $this->hasMany('App\Models\Mesa');
    }

    public function mesa($instancia_id)
    {
        $peticion = Mesa::where([
            'instancia_id' => $instancia_id,
            'materia_id' => $this->id
        ])->first();

        return $peticion;
    }

    public function comisiones()
    {
        return $this->belongsToMany(Comision::class);
    }
    public function getTotalAttribute()
    {

        return $this->comisiones()->count();
    }
}
