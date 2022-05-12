<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'materia_id',
        'proceso_id',
        'porcentaje_final',
        'porcentaje_presencial',
        'porcentaje_virtual'
    ];

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }

    public function proceso(){
        return $this->belongsTo('App\Models\Proceso','proceso_id');
    }

    public function asistencias_modulares()
    {
        return $this->hasMany('App\Models\AsistenciaModular');
    }

    public static function getByAsistenciaCargo($cargo_id,$asistencia_id)
    {
        $asistencia_modular = AsistenciaModular::where([
            'cargo_id'=>$cargo_id,
            'asistencia_id' => $asistencia_id
        ])->first();

        return $asistencia_modular;
    }
 
}
