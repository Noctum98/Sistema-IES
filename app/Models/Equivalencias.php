<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equivalencias extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'equivalencias';
    protected $fillable = ['alumno_id', 'materia_id', 'nota', 'fecha', 'resolution', 'user_id', 'ciclo_lectivo'];

    /**
     * @return null|string
     */
    public function nombreMateria(): ?string
    {
        $materia = Materia::where([
            'id' => $this->materia_id
        ])->first();

        return $materia->nombre;
    }

    /**
     * @return string|null
     */
    public function nombreCarrera(): ?string
    {

        $materia = Materia::where([
            'id' => $this->materia_id
        ])->first();

        $carrera = Carrera::where([
            'id' => $materia->carrera_id
        ])->first();



        return $carrera->nombre;
    }

    public function getAlumno(): ?Alumno
    {
        return Alumno::where([
            'id' => $this->alumno_id
        ])->first();

    }
}
