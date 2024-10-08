<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Database\Eloquent;

/**
 * Class Carrera
 * @package App\Models
 * @property int $id
 * @property string $nombre
 */
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
        'tipo',
        'link_inscripcion',
        'preinscripcion_habilitada',
        'matriculacion_habilitada',
        'inscripcion_habilitada',
        'resolucion_id'
    ];

    /**
     * @return BelongsTo
     */
    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    /**
     * @return HasMany
     */
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class)->orderBy('año', 'ASC')->orderBy('materias.nombre', 'ASC');
    }

    public function materias_segundo_cuatrimestre()
    {
        $materias = $this->materias()
        ->whereHas('masterMateria.regimen', function ($query) {
            $query->where('identifier', 'sem_2');
        })
        ->get();

    return $materias;
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class)->withTimestamps()->orderBy('apellidos');
    }

    public function alumnosVerificados()
    {
        return $this->belongsToMany(Alumno::class)->where('aprobado',true)->where('user_id','!=',null)->withTimestamps()->orderBy('apellidos');
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

    public function comisiones($año)
    {
        return Comision::where(['carrera_id' => $this->id, 'año' => $año])->get();
    }

    public function hasMaterias($año)
    {
        $materias = $this->materias->where('año', $año)->count();

        if ($materias > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function obtenerInstanciasCarrera(int $instancia)
    {
        return Carrera::select(
            'carreras.id as id',
            'carreras.nombre as nombre',
            'carreras.resolucion as resolucion',
            'sedes.nombre as sede'
        )
            ->join('sedes', 'carreras.sede_id', 'sedes.id')
            ->join('materias', 'carreras.id', 'materias.carrera_id')
            ->join('mesas', 'materias.id', 'mesas.materia_id')
            ->where('mesas.instancia_id', $instancia)
            ->groupBy('carreras.id', 'carreras.nombre', 'sedes.nombre')
            ->orderBy('sedes.nombre', 'asc')
//            ->orderBy('materias.nombre','asc')
            ->get();
    }

    public function obtenerAlumnosCicloLectivo(int $ciclo_lectivo)
    {
        return Alumno::select()
            ->leftJoin('alumno_carrera', 'alumnos.id', 'alumno_carrera.alumno_id')
            ->where('alumno_carrera.ciclo_lectivo', $ciclo_lectivo)
            ->where('alumno_carrera.carrera_id', $this->id)
            ->orderBy('alumnos.apellidos', 'asc')
//            ->orderBy('materias.nombre','asc')
            ->get();
    }

    public function materiasInscripto($idAlumno)
    {
        return $this->belongsToMany(Materia::class, 'inscripciones')->wherePivot('alumno_id', $idAlumno)->get();
    }

    public function scopeWithSede($query)
    {
        return $query->with('sede');
    }



    public function scopeWithCargos($query)
    {
        return $query->with('cargos');
    }

    public function scopeWithAlumnos($query)
    {
        return $query->with('alumnos');
    }


    /**
     * Obtén la relación "condicionCarrera".
     *
     * @return BelongsTo
     */
    public function condicionCarrera(): BelongsTo
    {
        return $this->belongsTo(CondicionCarrera::class, 'condicion_id');
    }

    /**
     * @return BelongsTo
     */
    public function resoluciones(): BelongsTo
    {
        return $this->belongsTo(Resoluciones::class, 'resolucion_id');
    }



}
