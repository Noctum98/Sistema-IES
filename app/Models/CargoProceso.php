<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function getCargosProcesosByCicloLectivo(int $cargo_id, int $ciclo_lectivo)
    {
        $mesas = CargoProceso::select('cargo_procesos.*')
            ->where('cargo_id', $cargo_id)
            ->where('ciclo_lectivo', $ciclo_lectivo);

    }

    public function getCierreCargoBool(): bool
    {

        $procesoCargo = ProcesosCargos::where('cargo_proceso_id', $this->id)->first();

        return (bool)$procesoCargo->cierre;


    }

    /**
     * @return ProcesosCargos
     */
    public function getProcesoCargo(): ProcesosCargos
    {
        $procesoCargo = ProcesosCargos::where('cargo_proceso_id', $this->id)->first();

        if(!$procesoCargo){
            $procesoCargo = ProcesosCargos::where([
                'proceso_id' => $this->proceso_id,
                'cargo_id' => $this->cargo_id
            ])->first();

            $procesoCargo->cargo_proceso_id = $this->id;
            $user = Auth::user();
            $procesoCargo->operador_id = $user->id;
            $procesoCargo->save();
        }

        return $procesoCargo;

    }
}
