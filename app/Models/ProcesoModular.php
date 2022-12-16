<?php

namespace App\Models;

use App\Services\ProcesoModularService;
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
        'asistencia_final_porcentaje',
        'asistencia_practica_profesional',
        'porcentaje_actividades_aprobado'
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

    public function timeUltimaModificacionModulo($materia_id)
    {
        $service = new ProcesoModularService();
        return $service->obtenerTimeUltimoProcesoModular($materia_id);
    }

    public function timeUltimaCalificacionModulo($materia_id)
    {
        $service = new ProcesoModularService();
        return $service->obtenerTimeUltimaCalificacion($materia_id);
    }


}
