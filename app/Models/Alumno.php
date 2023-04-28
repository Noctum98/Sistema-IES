<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carrera;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Alumno extends Model
{
    protected $fillable = [
        'user_id',
        'año',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'telefono_fijo',
        't_documento',
        'dni',
        'cuil',
        'imagen',
        'fecha',
        'edad',
        'genero',
        'regularidad',
        'materias_aprobadas',
        'nacionalidad',
        'calle',
        'n_calle',
        'barrio',
        'manzana',
        'casa',
        'residencia',
        'provincia',
        'localidad',
        'codigo_postal',
        'estado_civil',
        'ocupacion',
        'g_sanguineo',
        'escolaridad',
        'condicion_s',
        'escuela_s',
        'materias_s',
        'articulo_septimo',
        'privacidad',
        'poblacion_indigena',
        'discapacidad_mental',
        'discapacidad_intelectual',
        'discapacidad_visual',
        'discapacidad_auditiva',
        'discapacidad_motriz',
        'acompañamiento_motriz',
        'matriculacion',
        'pase',
        'titulo_s',
        'comision_id',
        'cohorte',
        'active',
        'fecha_primera_acreditacion',
        'fecha_ultima_acreditacion',
        'deleted_at',
        'aprobado'
    ];

    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class)->withTimestamps();
    }

    public function comisiones()
    {
        return $this->belongsToMany(Comision::class)->withTimestamps();
    }

    public function procesos()
    {
        return $this->hasMany('App\Models\Proceso');
    }

    public function procesos_actuales()
    {
        return $this->hasMany(Proceso::class)->where('ciclo_lectivo', date('Y'))->orderBy('id');
    }

    public function procesos_date($date)
    {
        return $this->hasMany(Proceso::class)->where('ciclo_lectivo', $date)->orderBy('id')->get();
    }

    public function asistencias()
    {
        return $this->hasMany('App\Models\AlumnoAsistencia');
    }

    public function alumno_carrera()
    {
        return $this->hasMany(AlumnoCarrera::class, 'alumno_id');
    }

    public function hasCarrera($carrera_id)
    {

        if ($this->carreras->where('id', $carrera_id)->first()) {
            return true;
        }
        return false;
    }

    public function procesoCarrera($carrera_id, $alumno_id, $ciclo_lectivo = null)
    {

        return AlumnoCarrera::where([
            'carrera_id' => $carrera_id,
            'alumno_id' => $alumno_id,
            'ciclo_lectivo' => $ciclo_lectivo ?? date('Y')
        ])->first();
    }

    public function lastProcesoCarrera($carrera_id)
    {
        return AlumnoCarrera::where([
            'carrera_id' => $carrera_id,
            'alumno_id' => $this->id,
        ])->latest()->first();
    }

    public function proceso($carrera_id)
    {
        $proceso = Proceso::where('alumno_id', $this->id)
            ->whereHas('materia', function ($query) use ($carrera_id) {
                $query->where('carrera_id', $carrera_id);
            })->first();

        return $proceso;
    }

    public function hasProceso($materia_id)
    {
        if($this->procesos->where('materia_id',$materia_id)->where('ciclo_lectivo',date('Y'))->first())
        {
            return true;
        }
        return false;
    }

    public function hasComision($comision_id)
    {
        if($this->comisiones->where('id',$comision_id)->first()){
            return true;
        }
        return false;
    }

    public function comisionPorAño($carrera_id, $año)
    {
        $comisiones = Comision::where([
            'carrera_id' => $carrera_id,
            'año' => $año
        ])->get();

        $respuesta = null;

        if($comisiones)
        {
            foreach($comisiones as $comision)
            {
                if($this->hasComision($comision->id))
                {
                    $respuesta = $comision->nombre;
                }
            }
        }

        return $respuesta;
    }

    // Functiones Estáticas

    public static function alumnosAño($year, $carrera_id, $ciclo_lectivo)
    {
        return Alumno::whereHas('alumno_carrera', function($query) use ($year, $carrera_id, $ciclo_lectivo) {
            $query->where('año', $year)
                  ->where('carrera_id', $carrera_id)
                  ->where('ciclo_lectivo', $ciclo_lectivo);
        })
            ->where('aprobado', true)
            ->orderBy('alumnos.apellidos', 'asc')
            ->get();
    }

    public function getApellidosNombresAttribute()
    {
        return $this->apellidos .', '. $this->nombres;
    }

    /**
     * @param $materia_id
     * @return mixed
     */
    public function getActaVolanteMateria($materia_id)
    {
        return ActaVolante::where([
            'materia_id' => $materia_id,
            'alumno_id' => $this->id
        ])
            ->orderBy('actas_volantes.updated_at','DESC')
            ->first();
    }

    public function getEquivalencias()
    {
        return Equivalencias::where([
                'equivalencias.alumno_id' => $this->id,]
        )
            ->orderBy('equivalencias.fecha', 'asc')
            ->get();
    }

    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class,'materias')
            ->withPivot('id','carrera_id');
    }


}
