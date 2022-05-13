<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaModular extends Model
{
    use HasFactory;
    protected $table = 'asistencias_modulares';
    protected $fillable = ['porcentaje','porcentaje_virtual','porcentaje_presencial','asistencia_id','cargo_id'];


    public function asistencia()
    {
        return $this->belongsTo('App\Models\Asistencia','asistencia_id');
    }

    public function cargo()
    {
        return $this->belongsTo('App\Models\Cargo','cargo_id');
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
