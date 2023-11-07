<?php

namespace App\Models;

use App\Services\AsistenciaModularService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Materia extends Model
{
    use HasFactory;

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

    public function carrera()
    {
        return $this->belongsTo('App\Models\Carrera', 'carrera_id');
    }

    public function profesores()
    {
        return $this->belongsToMany(User::class,'materia_user','materia_id','user_id');
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

    public function comisionesCiclo($ciclo_lectivo)
    {
        return $this->comisiones->where('ciclo_lectivo',$ciclo_lectivo);
    }

    public function mesa($instancia_id, $comision_id = null)
    {
        $mesa = Mesa::where([
            'instancia_id' => $instancia_id,
            'materia_id' => $this->id
        ]);

        if($comision_id)
        {
            $mesa = $mesa->where('comision_id',$comision_id);
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


    public function getTotalAttribute(): int
    {
        return $this->comisiones()->count();
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
        return Proceso::where(['materia_id' => $this->id, 'alumno_id', $alumno_id, 'ciclo_lectivo' => date('Y')])->first();
    }

    public function procesoAlumnoMateria(int $alumno)
    {
       return Proceso::where([
            'materia_id' => $this->id,
            'alumno_id' => $alumno
        ])->get();
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

        if(!$proceso){
            return null;
        }
        return $proceso;
    }


    /**
     * @param $alumno_id
     * @return mixed
     */
    public function getEstadoAlumnoPorMateria($alumno_id):string
    {
        $estado = '-';



        $proceso = Proceso::where([
                'materia_id' => $this->id,
                'alumno_id' => $alumno_id
            ]
        )->first();


        if(!$proceso){
            return $estado;
        }

        $regularidad = Regularidad::where([
            'proceso_id' => $proceso->id
        ])->first()
        ;

        if($regularidad){
            return $regularidad->obtenerEstado()->regularidad . ' <sup> <i>' . $regularidad->observaciones . '</i></sup>' ;
        }

        return $proceso->regularidad??'-';

    }

    public function getActaVolante($alumno_id)
    {
        $actaVolante = ActaVolante::where([
            'alumno_id' => $alumno_id,
            'materia_id' => $this->id
        ])
            ->orderBy('updated_at', 'DESC')
            ->first();


        if(!$actaVolante){
            return null;
        }
         return  $actaVolante;


    }

    public function correlativas()
    {
        return MateriasCorrelativa::where([
            'materia_id' => $this->id
        ]);
    }

    public function correlativasArray()
    {
        $correlativas =  MateriasCorrelativa::select('correlativa_id')
        ->where('materia_id', $this->id)
            ->get()->toArray();
        $correlativas = array_column($correlativas, 'correlativa_id');
        return $correlativas;


    }


}
