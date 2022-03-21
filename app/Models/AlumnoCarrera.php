<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoCarrera extends Model
{
    use HasFactory;
    protected $table = 'alumno_carrera';
    protected $fillable = [
        'alumno_id',
        'carrera_id',
        'año'
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
}
