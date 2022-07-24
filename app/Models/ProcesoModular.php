<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ProcesoModular extends Model
{
    use HasFactory;

    protected $table = "proceso_modular";
    protected $fillable = [

        'promedio_final_porcentaje',
        'promedio_final_nota',
        'ponderacion_promedio_final',
        'trabajo_final_porcentaje',
        'trabajo_final_nota',
        'ponderacion_trabajo_final',
        'nota_final_porcentaje',
        'nota_final_nota',
        'cierre',
        'operador_id',
        'proceso_id',
    ];

    public function procesoRelacionado()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function alumnoRelacionado()
    {
        $proceso =  $this->procesoRelacionado()->first();
        return $proceso->alumno()->first();
    }


}
