<?php

namespace App\Models;

use App\Models\Proceso\EtapaCampo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 *  Class Proceso
 * This is the model class for table "procesos"
 *
 * @property integer $id
 * @property integer $alumno_id
 * @property integer $materia_id
 * @property boolean $habilitado_campo
 * @property integer $ciclo_lectivo
 * @property integer $cargo_id
 * @property integer $operador_id
 * @property integer $nota_recuperatorio
 * @property integer $nota_global
 * @property integer $porcentaje_final_calificaciones
 * @property integer $final_calificaciones
 * @property boolean $cierre
 * @property integer $estado_id
 * @property double $final_asistencia
 *
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 * @method EloquentModel|Collection|null static $this find($id, $columns = ['*']) Find a model by its primary key.
 * @method static EloquentBuilder find($value)
 */
class Proceso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'alumno_id',
        'materia_id',
        'estado_id',
        'cierre',
        'final_calificaciones',
        'porcentaje_final_calificaciones',
        'nota_global',
        'nota_recuperatorio',
        'operador_id',
        'cargo_id',
        'ciclo_lectivo',
        'habilitado_campo',
        'final_asistencia'
    ];

    //Relations

    /**
     * @return BelongsTo
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo('App\Models\Materia', 'materia_id');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo('App\Models\Alumno', 'alumno_id')->withTrashed();
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'estado_id');
    }

    public function etapaCampo(): HasOne
    {
        return $this->hasOne(EtapaCampo::class, 'proceso_id');
    }

    public function cargos()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function procesoModularOne()
    {
        return $this->hasOne(ProcesoModular::class);
    }



    // Functions
    public function asistencia()
    {
        return Asistencia::where('proceso_id', $this->id)->first();
    }

    public function procesoCalificacion($calificacion_id)
    {
        $procesoCalificacion = ProcesoCalificacion::where(
            ['proceso_id' => $this->id, 'calificacion_id' => $calificacion_id]
        )->first();

        return $procesoCalificacion;
    }

    public function procesoModular()
    {
        return ProcesoModular::where(
            ['proceso_id' => $this->id]
        )
            ->get();
    }

    /**
     * @param int $cargo
     * @return mixed
     */
    public function obtenerProcesoCargo(int $cargo)
    {
        return ProcesosCargos::where([
            'cargo_id' => $cargo,
            'proceso_id' => $this->id
        ])->first();
    }

    /**
     * @param int $cargo
     * @return bool
     */
    public function isClose(int $cargo): bool
    {
        $procesoCargo = $this->obtenerProcesoCargo($cargo);
        if($procesoCargo && $procesoCargo->cierre){
            return true;
        }
        return false;
    }

    public function obtenerRegularidad()
    {
        return Regularidad::where([
            'proceso_id' => $this->id
        ])
            ->first();
    }

    public function procesosCalificaciones()
    {
        $procesosCalificaciones = ProcesoCalificacion::join('procesos', 'procesos.id', 'proceso_calificacion.proceso_id')
            ->join('alumnos', 'procesos.alumno_id', 'alumnos.id')
            ->join('calificaciones', 'calificaciones.id', 'proceso_calificacion.calificacion_id')
            ->where(
                ['proceso_id' => $this->id]
            )->where('calificaciones.tipo_id', 2)
            ->orderBy('calificacion_id', 'ASC')
            ->get();


        return $procesosCalificaciones;
    }

    public function calificacionTFI()
    {
        $calificacion_tfi = ProcesoCalificacion::join('calificaciones', 'calificaciones.id', 'proceso_calificacion.calificacion_id')
            ->where('proceso_id', $this->id)
            ->where('calificaciones.materia_id', $this->materia_id)
            ->where('calificaciones.tipo_id', 3)
            ->first();

        return $calificacion_tfi;
    }

    public function hasEquivalencia()
    {
        $equivalencia = Equivalencias::where([
            'materia_id' => $this->materia_id,
            'alumno_id' => $this->alumno_id
        ])->first();

        if($equivalencia)
        {
            return true;
        }

        return false;
    }

    /**
     * @param int $cargo_id
     * @return null|CargoProceso
     */
    public function getCargosProcesos(int $cargo_id): ?CargoProceso
    {
        return CargoProceso::where([
            'cargo_id' => $cargo_id,
            'proceso_id' => $this->id
        ])->first();
    }


}
