<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlumnoCarrera extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'alumno_carrera';
    protected $fillable = [
        'alumno_id',
        'carrera_id',
        'año',
        'ciclo_lectivo',
        'fecha_primera_acreditacion',
        'fecha_ultima_acreditacion',
        'cohorte',
        'legajo_completo',
        'aprobado',
        'regularidad'
    ];

    public function getCarrera($alumno_id,$carrera_id)
    {
        $alumno_carrera = self::where([
            'alumno_id' => $alumno_id,
            'carrera_id' => $carrera_id
        ])->first();

        if($alumno_carrera){
            return $alumno_carrera;
        }else{
            return false;
        }
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class,'carrera_id');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class,'alumno_id');
    }

}
