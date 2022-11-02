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
        return $this->belongsToMany(Alumno::class)->withTimestamps()->orderBy('apellidos');
    }

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }

    //============================ CARRERAS ====================================//
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function obtenerInstanciasCarrera(int $instancia)
    {
     return   Carrera::select(
            'carreras.id as id',
            'carreras.nombre as nombre',
            'sedes.nombre as sede'
        )
            ->join('sedes','carreras.sede_id','sedes.id')
            ->join('materias','carreras.id','materias.carrera_id')
            ->join('mesas','materias.id','mesas.materia_id')
            ->where('mesas.instancia_id',$instancia)
            ->groupBy('carreras.id', 'carreras.nombre', 'sedes.nombre')
            ->orderBy('sedes.nombre','asc')
//            ->orderBy('materias.nombre','asc')
            ->get();
    }
}
