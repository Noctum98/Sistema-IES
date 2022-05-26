<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'sede_id',
        'nombre',
        'titulo',
        'años',
        'resolucion',
        'modalidad',
        'turno',
        'vacunas',
        'estado',
        'tipo'
    ];

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

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }
}
