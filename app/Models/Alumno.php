<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carrera;
use Illuminate\Support\Facades\DB;

class Alumno extends Model
{
    protected $fillable = [
        'user_id',
        'año' ,
        'nombres' ,
        'apellidos' ,
        'email',
        'telefono' ,
        'telefono_fijo',
        't_documento' ,
        'dni' ,
        'cuil' ,
        'imagen' ,
        'fecha' ,
        'edad' ,
        'genero' ,
        'regularidad' ,
        'materias_aprobadas' ,
        'nacionalidad' ,
        'calle' ,
        'n_calle',
        'barrio',
        'manzana',
        'casa',
        'residencia' ,
        'provincia',
        'localidad',
        'codigo_postal' ,
        'estado_civil' ,
        'ocupacion' ,
        'g_sanguineo' ,
        'escolaridad' ,
        'condicion_s' ,
        'escuela_s' ,
        'materias_s' ,
        'articulo_septimo',
        'privacidad' ,
        'poblacion_indigena' ,
        'discapacidad_mental' ,
        'discapacidad_intelectual' ,
        'discapacidad_visual' ,
        'discapacidad_auditiva' ,
        'discapacidad_motriz' ,
        'acompañamiento_motriz' ,
        'matriculacion' ,
        'pase' ,
        'titulo_s'
    ];

    use HasFactory;

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class)->withTimestamps();
    }
    public function procesos()
    {
        return $this->hasMany('App\Models\Proceso');
    }
    public function asistencias(){
        return $this->hasMany('App\Models\AlumnoAsistencia');
    }

    public function hasCarrera($carrera_id)
    {

        if ($this->carreras->where('id', $carrera_id)->first()) {
            return true;
        }
        return false;
    }

    public function procesoCarrera($carrera_id,$alumno_id)
    {
        $procesoCarrera = AlumnoCarrera::where([
            'carrera_id' => $carrera_id,
            'alumno_id' => $alumno_id
        ])->first();

        return $procesoCarrera;
    }

    public function hasProceso($materia_id)
    {
        if($this->procesos->where('materia_id',$materia_id)->first())
        {
            return true;
        }
        return false;
    }

    // Functiones Estáticas

    public static function alumnosAño($year,$carrera_id)
    {
        return Alumno::select(
            'alumnos.nombres',
            'alumnos.apellidos',
            'alumnos.dni',
            'alumnos.email',
            'alumnos.telefono',
            'alumnos.regularidad',
            'alumnos.genero'
        )
        ->join('alumno_carrera','alumno_carrera.alumno_id','alumnos.id')
        ->where('alumno_carrera.año',$year)
        ->where('alumno_carrera.carrera_id',$carrera_id)
        ->orderBy('alumnos.apellidos','asc')
        ->get();
    }
}
