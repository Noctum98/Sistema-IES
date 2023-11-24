<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 */
class Asistencia extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'proceso_id',
        'porcentaje_final',
        'porcentaje_presencial',
        'porcentaje_virtual',
        'comision_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proceso(){
        return $this->belongsTo('App\Models\Proceso','proceso_id');
    }

    /**
     * @return HasMany
     */
    public function asistencias_modulares()
    {
        return $this->hasMany('App\Models\AsistenciaModular');
    }

    /**
     * @param $cargo_id
     * @return AsistenciaModular
     */
    public function getByAsistenciaCargo($cargo_id)
    {
        $asistencia_modular = AsistenciaModular::where([
            'cargo_id'=>$cargo_id,
            'asistencia_id' => $this->id
        ])->first();

        return $asistencia_modular;
    }

}
