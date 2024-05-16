<?php

namespace App\Models;

use App\Models\Alumno\EncuestaSocioeconomica;
use App\Models\Trianual\Trianual;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
//use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Alumno
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $año
 * @property string $nombres
 * @property string $apellidos
 * @property string $email
 * @property string $telefono
 * @property string|null $telefono_fijo
 * @property string $dni
 * @property string|null $cuil
 * @property string|null $imagen
 * @property string|null $fecha
 * @property string|null $edad
 * @property string|null $genero
 * @property string|null $regularidad
 * @property string|null $nacionalidad
 * @property string|null $provincia
 * @property string|null $localidad
 * @property string|null $calle
 * @property string|null $n_calle
 * @property string|null $barrio
 * @property string|null $manzana
 * @property int|null $casa
 * @property string|null $codigo_postal
 * @property string|null $estado_civil
 * @property string|null $ocupacion
 * @property string|null $g_sanguineo
 * @property string|null $escolaridad
 * @property string|null $condicion_s
 * @property string|null $escuela_s
 * @property string|null $materias_s
 * @property int|null $titulo_s
 * @property string|null $articulo_septimo
 * @property int|null $privacidad
 * @property int|null $poblacion_indigena
 * @property string|null $discapacidad_mental
 * @property string|null $discapacidad_intelectual
 * @property string|null $discapacidad_visual
 * @property string|null $discapacidad_auditiva
 * @property string|null $discapacidad_motriz
 * @property string|null $acompañamiento_motriz
 * @property string|null $matriculacion
 * @property string|null $pase
 * @property string|null $fecha_primera_acreditacion
 * @property string|null $fecha_ultima_acreditacion
 * @property string|null $legajo_completo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $comision_id
 * @property string|null $cohorte
 * @property int|null $active
 * @property string|null $aprobado
 * @property Carbon|null $deleted_at
 * @property int|null $operador_id
 * @property-read Collection<int, AlumnoCarrera> $alumno_carrera
 * @property-read int|null $alumno_carrera_count
 * @property-read Collection<int, AlumnoAsistencia> $asistencias
 * @property-read int|null $asistencias_count
 * @property-read Collection<int, Carrera> $carreras
 * @property-read int|null $carreras_count
 * @property-read Collection<int, Carrera> $carrerasDistinct
 * @property-read int|null $carreras_distinct_count
 * @property-read Collection<int, Comision> $comisiones
 * @property-read int|null $comisiones_count
 * @property-read EncuestaSocioeconomica|null $encuesta_socioeconomica
 * @property-read mixed $apellidos_nombres
 * @property-read Collection<int, Proceso> $lastProceso
 * @property-read int|null $last_proceso_count
 * @property-read Collection<int, Materia> $materias
 * @property-read int|null $materias_count
 * @property-read Collection<int, Proceso> $procesos
 * @property-read int|null $procesos_count
 * @property-read Collection<int, Proceso> $procesos_actuales
 * @property-read int|null $procesos_actuales_count
 * @property-read User|null $user
 * @method static Builder|Alumno newModelQuery()
 * @method static Builder|Alumno newQuery()
 * @method static Builder|Alumno onlyTrashed()
 * @method static Builder|Alumno query()
 * @method static Builder|Alumno whereAcompañamientoMotriz($value)
 * @method static Builder|Alumno whereActive($value)
 * @method static Builder|Alumno whereApellidos($value)
 * @method static Builder|Alumno whereAprobado($value)
 * @method static Builder|Alumno whereArticuloSeptimo($value)
 * @method static Builder|Alumno whereAño($value)
 * @method static Builder|Alumno whereBarrio($value)
 * @method static Builder|Alumno whereCalle($value)
 * @method static Builder|Alumno whereCasa($value)
 * @method static Builder|Alumno whereCodigoPostal($value)
 * @method static Builder|Alumno whereCohorte($value)
 * @method static Builder|Alumno whereComisionId($value)
 * @method static Builder|Alumno whereCondicionS($value)
 * @method static Builder|Alumno whereCreatedAt($value)
 * @method static Builder|Alumno whereCuil($value)
 * @method static Builder|Alumno whereDeletedAt($value)
 * @method static Builder|Alumno whereDiscapacidadAuditiva($value)
 * @method static Builder|Alumno whereDiscapacidadIntelectual($value)
 * @method static Builder|Alumno whereDiscapacidadMental($value)
 * @method static Builder|Alumno whereDiscapacidadMotriz($value)
 * @method static Builder|Alumno whereDiscapacidadVisual($value)
 * @method static Builder|Alumno whereDni($value)
 * @method static Builder|Alumno whereEdad($value)
 * @method static Builder|Alumno whereEmail($value)
 * @method static Builder|Alumno whereEscolaridad($value)
 * @method static Builder|Alumno whereEscuelaS($value)
 * @method static Builder|Alumno whereEstadoCivil($value)
 * @method static Builder|Alumno whereFecha($value)
 * @method static Builder|Alumno whereFechaPrimeraAcreditacion($value)
 * @method static Builder|Alumno whereFechaUltimaAcreditacion($value)
 * @method static Builder|Alumno whereGSanguineo($value)
 * @method static Builder|Alumno whereGenero($value)
 * @method static Builder|Alumno whereId($value)
 * @method static Builder|Alumno whereImagen($value)
 * @method static Builder|Alumno whereLegajoCompleto($value)
 * @method static Builder|Alumno whereLocalidad($value)
 * @method static Builder|Alumno whereManzana($value)
 * @method static Builder|Alumno whereMateriasS($value)
 * @method static Builder|Alumno whereMatriculacion($value)
 * @method static Builder|Alumno whereNCalle($value)
 * @method static Builder|Alumno whereNacionalidad($value)
 * @method static Builder|Alumno whereNombres($value)
 * @method static Builder|Alumno whereOcupacion($value)
 * @method static Builder|Alumno whereOperadorId($value)
 * @method static Builder|Alumno wherePase($value)
 * @method static Builder|Alumno wherePoblacionIndigena($value)
 * @method static Builder|Alumno wherePrivacidad($value)
 * @method static Builder|Alumno whereProvincia($value)
 * @method static Builder|Alumno whereRegularidad($value)
 * @method static Builder|Alumno whereTelefono($value)
 * @method static Builder|Alumno whereTelefonoFijo($value)
 * @method static Builder|Alumno whereTituloS($value)
 * @method static Builder|Alumno whereUpdatedAt($value)
 * @method static Builder|Alumno whereUserId($value)
 * @method static Builder|Alumno withTrashed()
 * @method static Builder|Alumno withoutTrashed()
 * @mixin Eloquent
 */
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

    public function user(): BelongsTo
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



    public function comisiones(): BelongsToMany
    {
        return $this->belongsToMany(Comision::class)->withTimestamps();
    }

    public function procesos(): HasMany
    {
        return $this->hasMany('App\Models\Proceso');
    }

    public function procesos_actuales(): HasMany
    {
        return $this->hasMany(Proceso::class)->where('ciclo_lectivo', date('Y'))->orderBy('id');
    }

    public function procesos_date($date)
    {
        return $this->hasMany(Proceso::class)->where('ciclo_lectivo', $date)->orderBy('id')->get();
    }

    public function lastProceso(): HasMany
    {
        return $this->hasMany(Proceso::class)->latest();
    }

    public function asistencias(): HasMany
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

    public function hasCarrera($carrera_id): bool
    {

        if ($this->carreras->where('id', $carrera_id)->first()) {
            return true;
        }
        return false;
    }

    public function procesoCarrera($carrera_id, $alumno_id, $ciclo_lectivo = null): AlumnoCarrera
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

    public function lastProcesoCarrera($carrera_id, $ciclo_lectivo = null): AlumnoCarrera
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


    public function hasProceso($materia_id,$ciclo_lectivo = null): bool
    {
        $ciclo = $ciclo_lectivo ?? date('Y');
        if ($this->procesos->where('materia_id', $materia_id)->where('ciclo_lectivo',$ciclo)->first()) {
            return true;
        }
        return false;
    }

    public function hasComision($comision_id): bool
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

    // Funciones Estáticas

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


        return $alumnos->orderBy('alumnos.apellidos')
            ->get();
    }

    /**
     * @return string
     */
    public function getApellidosNombresAttribute(): string
    {
        return mb_strtoupper($this->apellidos) . ', ' . ucwords($this->nombres);
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
            ->orderBy('equivalencias.fecha')
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


    public function getRegularidades()
    {
        return Regularidad::select('regularidades.*')
            ->leftJoin('procesos', 'regularidades.proceso_id', 'procesos.id')
            ->leftJoin('materias', 'materias.id', 'procesos.materia_id')
            ->where('procesos.alumno_id', $this->id)
            ->orderBy('procesos.ciclo_lectivo', 'desc')
            ->orderBy('materias.nombre')
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
    /**
     * Verifica si el estudiante tiene alguna calificación.
     *
     * @return bool Devuelve verdadero si el estudiante tiene calificaciones, falso en caso contrario.
     */
    public function hasNotas(): bool
    {
        $notas = $this->hasManyThrough(
            ProcesoCalificacion::class, // Modelo destino
            Proceso::class, // Modelo intermedio
            'alumno_id', // FK en tabla modelo intermedio
            'proceso_id', // FK en tabla modelo destino
            'id',  // PK tabla local
            'id'  // PK Tabla intermedia
        )->get();

        if ($notas->isNotEmpty()) {
                return true;
            }
            return false;
    }




    /**
     * @return string
     */
    public function getDocumento():string
    {
        return $this->t_documento?$this->t_documento .": " : " " . $this->dni;
    }


    public function getEdadAttribute(): int
    {
        return Carbon::parse($this->attributes['fecha'])->age;
    }
}
