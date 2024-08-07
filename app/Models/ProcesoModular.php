<?php

namespace App\Models;

use App\Services\ProcesoModularService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property double $asistencia_final_porcentaje
 * @property double $nota_final_porcentaje
 * @property double $nota_final_nota
 */
class ProcesoModular extends Model
{
    use HasFactory, SoftDeletes;

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
        'porcentaje_actividades_aprobado',
        'ciclo_lectivo'
    ];

    public function procesoRelacionado(): BelongsTo
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function alumnoRelacionado()
    {
        $proceso = $this->procesoRelacionado()->first();

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

    public function obtenerPorcentajeActividadesAprobadasPorMateriaCargo($materia_id, $cargo_id, $ciclo_lectivo = null): float
    {
        $service = new ProcesoModularService();

        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        return $service->obtenerPorcentajeProcesoAprobado(
            $this->procesoRelacionado()->first()->id,
            $materia_id,
            $cargo_id,
            $ciclo_lectivo
        );

    }

    public function obtenerPorcentajeActividadesAprobadasPorMateriaCargoSelf(): array
    {
        $service = new ProcesoModularService();

        $porcentaje = [];

        $materia_id = $this->procesoRelacionado()->first()->materia_id;
        $cargos = $this->getIdCargos();
        $ciclo_lectivo = $this->procesoRelacionado()->first()->ciclo_lectivo;
        if(!$ciclo_lectivo){
            $ciclo_lectivo = date('Y');
        }

        foreach ($cargos as $cargo) {

            $porcentaje[$cargo] = $service->obtenerPorcentajeProcesoAprobado(
                $this->procesoRelacionado()->first()->id,
                $materia_id,
                $cargo,
                $ciclo_lectivo
            );
        }


        return $porcentaje;



    }

    public function getCicloLectivo()
    {

        $cicloLectivo = $this->ciclo_lectivo;
        if (!$cicloLectivo) {

            $cicloLectivo = $this->procesoRelacionado()->first()->ciclo_lectivo;
        }

        return $cicloLectivo;
    }

    public function getIdCargos(): array
    {
        return ProcesosCargos::where('proceso_id', $this->proceso_id)->get()->pluck('cargo_id')->toArray();
    }


}
