<?php

namespace App\Models;

use App\Models\Parameters\CicloLectivo;
use App\Models\Parameters\CicloLectivoEspecial;
use App\Services\AsistenciaModularService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\HigherOrderCollectionProxy;


/**
 * Class Materia
 * @package App\Models
 * @property int $carrera_id
 * @property int $año
 * @property string $nombre
 * @property string $regimen
 * @property int $tipo_materia_id
 * @property float $asistencia_ponderada
 * @property float $proceso_ponderado
 * @property string $etapa_campo
 * @property string $cierre_diferido
 * @property-read Carrera $carrera
 * @property-read TipoMateria $tipoMateria
 * @property-read null|Collection|Cargo[] $cargos
 * @property-read Materia $correlativa
 * @property-read null|Collection|MesaAlumno[] $mesa_inscriptos
 * @property-read null|Collection|Mesa[] $mesas
 * @property-read null|Collection|Comision[] $comisiones
 * @property-read int $total
 *
 */
class Materia extends BaseModel
{

    const PRI_SEM = "Cuatrimestral (1er)";
    const SEC_SEM = "Cuatrimestral (2do)";
    const ANUAL = "Anual";

    protected $fillable = [
        'carrera_id',
        'año',
        'nombre',
        'regimen',
        'tipo_materia_id',
        'asistencia_ponderada',
        'proceso_ponderado',
        'etapa_campo',
        'cierre_diferido'
    ];

    /**
     * @return BelongsTo
     */
    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function tipoMateria(): BelongsTo
    {
        return $this->belongsTo(TipoMateria::class, 'tipo_materia_id');
    }

    /**
     * @return null | BelongsToMany
     */
    public function cargos(): ?BelongsToMany
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
    public function correlativaCursado(): HasMany
    {
        return $this->HasMany(Materia::class, 'correlativaCursado');
    }

    public function mesa_inscriptos()
    {
        return $this->hasMany('App\Models\MesaAlumno');
    }

    public function mesas()
    {
        return $this->hasMany('App\Models\Mesa');
    }

    public function comisiones()
    {
        return $this->belongsToMany(Comision::class);
    }

    public function getTotalAttribute(): int
    {
        return $this->comisiones()->count();
    }

    public function mesa($instancia_id, $comision_id = null)
    {
        $mesa = Mesa::where([
            'instancia_id' => $instancia_id,
            'materia_id' => $this->id
        ]);

        if ($comision_id) {
            $mesa = $mesa->where('comision_id', $comision_id);
        }

        return $mesa->first();
    }

    public function mesas_instancias($instancia_id)
    {
        return Mesa::where([
            'instancia_id' => $instancia_id,
            'materia_id' => $this->id
        ])->get();
    }

    public function mesasByMateria($instancia_id, $materias, $comision = null)
    {

        $mesas = Mesa::select('mesas.*')
            ->where('mesas.instancia_id', $instancia_id)
            ->whereIn('mesas.materia_id', $materias);

        if ($comision) {
            $mesas = $mesas->where('mesas.comision_id', $comision);
        }

        $mesas->orderBy('mesas.instancia_id', 'asc');

        return $mesas->get();
    }

    public function totalModulo()
    {
        $total_modulo = 0;
        $cargos_modulo = CargoMateria::where([
            'materia_id' => $this->id
        ])->get();

        foreach ($cargos_modulo as $cm) {
            $total_modulo = $cm->ponderacion + $total_modulo;

        }

        return $total_modulo;
    }

    public function obtenerPonderacionAsistencia()
    {
        $servicioAsistencia = new AsistenciaModularService();

        return $servicioAsistencia->ponderarAsistencias($this);

    }

    public function proceso($alumno_id)
    {
        return Proceso::where([
            'materia_id' => $this->id,
            'alumno_id', $alumno_id,
            'ciclo_lectivo' => date('Y')])->first();
    }

    /**
     * @param $alumno_id
     * @return mixed
     */
    public function getProcesoCarrera($alumno_id)
    {
        $proceso = Proceso::where([
                'materia_id' => $this->id,
                'alumno_id' => $alumno_id
            ]
        )->first();

        if (!$proceso) {
            return null;
        }
        return $proceso;
    }


    /**
     * @param $alumno_id
     * @return mixed
     */
    public function getEstadoAlumnoPorMateria($alumno_id): string
    {
        $estado = '-';

        $proceso = Proceso::where([
                'materia_id' => $this->id,
                'alumno_id' => $alumno_id
            ]
        )->latest('created_at')->first();

        if (!$proceso) {
            return $estado;
        }

        $regularidad = Regularidad::where([
            'proceso_id' => $proceso->id
        ])->first();

        if ($regularidad) {
            return $regularidad->obtenerEstado()->regularidad
                . ' <sup> <i>' . $regularidad->observaciones . '</i></sup>';
        }

        return $proceso->estadoRegularidad() ?? '-';

    }

    public function getActaVolante($alumno_id)
    {
        $actaVolante = ActaVolante::where([
            'alumno_id' => $alumno_id,
            'materia_id' => $this->id
        ])->where('promedio','>=',4)->orderBy('created_at', 'DESC')
        ->first();
        
        if(!$actaVolante)
        {
            $actaVolante = ActaVolante::where([
                'alumno_id' => $alumno_id,
                'materia_id' => $this->id
            ])->orderBy('created_at', 'DESC')
            ->first();
        }
    

        if($actaVolante)
        {
            $created_at = date('Y', strtotime($actaVolante->created_at));
            if($created_at >= $actaVolante->inscripcionCarrera->cohorte){
                return $actaVolante;
            }
        }

        return null;
    }


    /**
     * Devuelve los ActaVolantes para el alumno especificado.
     *
     * @param int $alumno_id El ID del alumno.
     * @return ActaVolante[]|Collection|null Devuelve una colección de ActaVolantes para el alumno especificado,
     *  o null si no se encuentran ActaVolantes.
     */
    public function getActasVolantesConLibro($alumno_id)
    {
        $actaVolantes = ActaVolante::where([
            'alumno_id' => $alumno_id,
            'materia_id' => $this->id
        ])
            ->whereNotNull('libro_id')
            ->orderBy('updated_at', 'DESC')
            ->get();

        if (!$actaVolantes) {
            return null;
        }
        return $actaVolantes;
    }

    public function correlativas()
    {
        return MateriasCorrelativa::where([
            'materia_id' => $this->id
        ]);
    }

    public function materiasCorrelativas(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class,'materias_correlativas','materia_id','correlativa_id');
    }

    public function correlativasArray()
    {
        $correlativas = MateriasCorrelativa::select('correlativa_id')
            ->where('materia_id', $this->id)
            ->get()->toArray();
        $correlativas = array_column($correlativas, 'correlativa_id');


        return $correlativas;
    }

    /**
     * @return MateriasCorrelativasCursado
     */
    public function correlativasCursado(): MateriasCorrelativasCursado
    {
        return MateriasCorrelativasCursado::where([
            'materia_id' => $this->id
        ]);
    }

    /**
     * @return array
     */
    public function correlativasCursadoArray(): array
    {
        $correlativasCursado = MateriasCorrelativasCursado::select('previa_id')
            ->where('materia_id', $this->id)
            ->get()->toArray();
        return array_column($correlativasCursado, 'previa_id');

    }

    public function ciclosLectivosDiferenciados()
    {

        return CicloLectivoEspecial::where([
            'materia_id' => $this->id,
            'sede_id' => $this->sede()->id
        ])
            ->get();

    }

    public function sede()
    {
        return $this->carrera()->first()->sede()->first();
    }

    /**
     * @return string
     */
    public function getProfesoresModulares(): string
    {

        $profesores = '';
        if (count($this->cargos()->get()) > 0) {
            foreach ($this->cargos()->get() as $cargo) {
                /** @var Cargo $cargo */
                $profesores .= $cargo->profesores() . "\n";
            }
        }
        return $profesores;
    }

    /**
     * @param int $ciclo_lectivo
     * @param int|null $comision_id
     * @return Proceso[]|Collection
     */
    public function getProcesos(int $ciclo_lectivo, int $comision_id = null)
    {
        $procesos = $this->getBuilderProceso($ciclo_lectivo);

        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }

        $procesos->orderBy('alumnos.apellidos', 'asc');

        return $procesos->get();
    }

    /**
     * Obtenga el queryBuilder para recuperar Procesos.
     *
     * @param int $ciclo_lectivo El ciclo lectivo de los registros de Proceso a recuperar.
     */
    protected function getBuilderProceso(int $ciclo_lectivo)
    {
        return Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $this->id)
            ->where('procesos.ciclo_lectivo', $ciclo_lectivo);
    }

    /**
     * @param int $ciclo_lectivo
     * @return Carbon|HigherOrderCollectionProxy|mixed
     */
    public function getCierre(int $ciclo_lectivo)
    {
        $ciclo_lectivo = CicloLectivo::find($ciclo_lectivo);
        $regimen = $this->regimen;

        switch ($regimen) {
            case self::ANUAL:
                $cierre = $ciclo_lectivo->anual;
                break;
            case self::PRI_SEM:
                $cierre = $ciclo_lectivo->fst_sem;
                break;
            case self::SEC_SEM:
                $cierre = $ciclo_lectivo->snd_sem;
                break;
            default:
                $cierre = now();
        }

        return $cierre;

    }


}
