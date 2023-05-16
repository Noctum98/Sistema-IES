<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Regularidad extends Model
{
    use HasFactory;

    protected $table = "regularidades";
    protected $fillable = [
        'proceso_id',
        'fecha_regularidad',
        'observaciones',
        'operador_id',
        'fecha_vencimiento',
        'estado_id'
    ];

    protected $dates = [
        'fecha_regularidad',
        'fecha_vencimiento'
    ];

    /**
     * @return Materia|null
     */
    public function obtenerMateria():?Materia
    {
        $proceso = Proceso::where([
           'id' => $this->proceso_id
        ]);

        return Materia::where([
           'id' => $proceso->materia_id
        ]);

    }

    /**
     * @return Alumno|null
     */
    public function obtenerAlumno():?Alumno
    {
        $proceso = Proceso::where([
           'id' => $this->proceso_id
        ]);

        return Alumno::where([
           'id' => $proceso->alumno_id
        ]);

    }

    public function obtenerEstado()
    {
        return Estados::find($this->estado_id);
    }
}
