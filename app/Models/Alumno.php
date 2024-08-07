<?php

namespace App\Models;

use App\Models\Alumno\EncuestaSocioeconomica;
use App\Models\Trianual\Trianual;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carrera;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Alumno extends Model
{
    use HasFactory, SoftDeletes;

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
        'aprobado',
        'operador_id',
        'legajo_completo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carreras(): BelongsToMany
    {
        return $this->belongsToMany(Carrera::class)->withTimestamps()->wherePivot('ciclo_lectivo', date('Y'));
    }

    public function carrerasDistinct(): BelongsToMany
    {
        return $this->belongsToMany(Carrera::class)->distinct();
    }

    /**
     * @param $ciclo_lectivo
     * @return BelongsToMany
     */
    public function carrerasByCicloLectivo($ciclo_lectivo): BelongsToMany
    {
        return $this->belongsToMany(Carrera::class)->withTimestamps()->wherePivot('ciclo_lectivo', $ciclo_lectivo);
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

    public function lastProceso()
    {
        return $this->hasMany(Proceso::class)->latest();
    }

    public function asistencias()
    {
        return $this->hasMany('App\Models\AlumnoAsistencia');
    }

    public function alumno_carrera(): HasMany
    {
        return $this->hasMany(AlumnoCarrera::class, 'alumno_id');
    }


    public function encuesta_socioeconomica(): HasOne
    {
        return $this->hasOne(EncuestaSocioeconomica::class);
    }

    public function getEncuestaSocioeconomica()
    {
        return EncuestaSocioeconomica::where('alumno_id',$this->id)->first();
    }

    public function hasCarrera($carrera_id)
    {

        if ($this->carreras->where('id', $carrera_id)->first()) {
            return true;
        }
        return false;
    }

    public function procesoCarrera($carrera_id, $alumno_id = null, $ciclo_lectivo = null)
    {

        return AlumnoCarrera::where([
            'carrera_id' => $carrera_id,
            'alumno_id' => $alumno_id,
            'ciclo_lectivo' => $ciclo_lectivo ?? date('Y')
        ])->latest()->first();
    }

    public function procesoByMateria($materia_id,$ciclo_lectivo)
    {
        return $this->hasOne(Proceso::class)->where('materia_id',$materia_id)->where('ciclo_lectivo',$ciclo_lectivo)->first();
    }

    public function lastProcesoCarrera($carrera_id, $ciclo_lectivo = null)
    {
        $alumnoCarrera = AlumnoCarrera::where([
            'carrera_id' => $carrera_id,
            'alumno_id' => $this->id,
        ]);

        if ($ciclo_lectivo) {
            $alumnoCarrera = $alumnoCarrera->where('ciclo_lectivo', $ciclo_lectivo);
        }

        return $alumnoCarrera->latest()->first();
    }


    public function hasProceso($materia_id,$ciclo_lectivo = null)
    {
        $ciclo = $ciclo_lectivo ?? date('Y');
        if ($this->procesos->where('materia_id', $materia_id)->where('ciclo_lectivo',$ciclo)->first()) {
            return true;
        }
        return false;
    }

    public function hasComision($comision_id)
    {
        if ($this->comisiones->where('id', $comision_id)->first()) {
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

        if ($comisiones) {
            foreach ($comisiones as $comision) {
                if ($this->hasComision($comision->id)) {
                    $respuesta = $comision->nombre;
                }
            }
        }

        return $respuesta;
    }

    // Functiones Estáticas

    public static function alumnosAño($year, $carrera_id, $ciclo_lectivo, $comision_id)
    {
        $alumnos = Alumno::whereHas('alumno_carrera', function ($query) use ($year, $carrera_id, $ciclo_lectivo) {
            $query->where('alumno_carrera.año', $year)
                ->where('alumno_carrera.carrera_id', $carrera_id)
                ->where('alumno_carrera.ciclo_lectivo', $ciclo_lectivo)
                ->where('alumno_carrera.aprobado',true);
        });

        if ($comision_id) {
            $alumnos = $alumnos->whereHas('comisiones', function ($query) use ($comision_id) {
                $query->where('comisiones.id', $comision_id);
            });
        }


        $alumnos = $alumnos->orderBy('alumnos.apellidos', 'asc')
            ->get();

        return $alumnos;
    }

    public function getApellidosNombresAttribute()
    {
        return mb_strtoupper($this->apellidos) . ', ' . ucwords($this->nombres);
    }

    public function getEquivalencias()
    {
        return Equivalencias::where([
                'equivalencias.alumno_id' => $this->id,]
        )
            ->orderBy('equivalencias.fecha', 'asc')
            ->get();
    }

    /**
     * @param $materia
     * @param $ciclo_lectivo
     * @return bool
     */
    public function hasEquivalenciaMateriaCicloLectivo($materia, $ciclo_lectivo): bool
    {
        $equivalencias = Equivalencias::where([
                'equivalencias.alumno_id' => $this->id,
                'equivalencias.materia_id' => $materia,
                'equivalencias.ciclo_lectivo' => $ciclo_lectivo,
            ]
        )->first();

        if ($equivalencias) {
            return true;
        }
        return false;
    }

    public function getNotaEquivalenciaMateriaCicloLectivo($materia, $ciclo_lectivo)
    {
        $equivalencias = Equivalencias::where([
                'equivalencias.alumno_id' => $this->id,
                'equivalencias.materia_id' => $materia,
                'equivalencias.ciclo_lectivo' => $ciclo_lectivo,
            ]
        )->select('nota')
            ->first();
        return $equivalencias->nota;
    }

    /**
     * @param $materia
     * @param $ciclo_lectivo
     * @return string
     */
    public function infoEquivalenciaMateriaCicloLectivo($materia, $ciclo_lectivo): string
    {
        $equivalencia = Equivalencias::where([
                'equivalencias.alumno_id' => $this->id,
                'equivalencias.materia_id' => $materia,
                'equivalencias.ciclo_lectivo' => $ciclo_lectivo,
            ]
        )
            ->first();

        $user = User::find($equivalencia->user_id);
        $nombreApellido = "";
        if($user){
            $nombreApellido = ". Cargada por: " . $user->getApellidoNombre();
        }
        /** @var Equivalencias $equivalencia */
        return "Resolución: " . $equivalencia->resolution . " del " . $equivalencia->fecha . $nombreApellido;
    }

    /**
     * @return mixed
     */
    public function getRegularidades()
    {
        return Regularidad::select('regularidades.*')
            ->leftJoin('procesos', 'regularidades.proceso_id', 'procesos.id')
            ->leftJoin('materias', 'materias.id', 'procesos.materia_id')
            ->where('procesos.alumno_id', $this->id)
            ->orderBy('procesos.ciclo_lectivo', 'desc')
            ->orderBy('materias.nombre', 'asc')
            ->get();
    }

    public function isRegular(int $ciclo_lectivo = null)
    {
        $qb = Proceso::select()
            ->leftJoin('alumnos', 'procesos.alumno_id', 'alumnos.id')
            ->leftJoin('estados', 'procesos.estado_id', 'estados.id')
            ->whereIn('estados.identificador', [1, 3, 4]);
        if ($ciclo_lectivo) {
            $qb->where('ciclo_lectivo', '=', $ciclo_lectivo);
        }

        return $qb->get();
    }


    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'materias')
            ->withPivot('id', 'carrera_id');
    }

    public function getTrianual(): HasOne
    {
        return $this->hasOne(Trianual::class, 'alumno_id');
    }


    /**
     * Obtiene una "condicionCarrera" relacionada.
     *
     * @return BelongsTo
     */
    public function condicionCarrera(): BelongsTo
    {
        return $this->belongsTo(CondicionCarrera::class, 'condicion_carrera_id');
    }

    public function getEdadAttribute(): int
    {
        return Carbon::parse($this->attributes['fecha'])->age;
    }


}
