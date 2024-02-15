<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  Class CargoProceso
 * This is the model class for table "cargo_procesos"
 *
 * @property integer $id
 * @property integer $cargo_id
 * @property integer $proceso_id
 */
class CargoProceso extends Model
{
    use HasFactory;

    protected $table = 'cargo_procesos';
    protected $fillable = [
        'user_id',
        'cargo_id',
        'proceso_id',
        'ciclo_lectivo',
        'cantidad_tp',
        'suma_tp',
        'nota_tp',
        'cantidad_ps',
        'suma_ps',
        'nota_ps',
        'nota_cargo',
        'nota_ponderada',
        'porcentaje_asistencia'
    ];

    public function getCargosProcesosByProcesos(int $cargo_id, array $procesos)
    {
        $mesas = CargoProceso::select('cargo_procesos.*')
            ->where('cargo_id', $cargo_id)
            ->whereIn('proceso_id', $procesos);


        return $mesas->get();
    }
}
