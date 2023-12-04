<?php

namespace App\Services;

use App\Models\ProcesoModular;
use App\Models\ProcesosCargos;
use DateTime;

class ProcesosCargosService
{

    /**
     * @param int $proceso
     * @param int $cargo
     * @param int $user
     * @param bool $cierre
     * @return ProcesosCargos
     */
    public function crear(int $proceso, int $cargo, int $user, bool $cierre = true): ProcesosCargos
    {

        $data['proceso_id'] = $proceso;
        $data['cargo_id'] = $cargo;
        $data['operador_id'] = $user;
        $data['cierre'] = null;

        if ($cierre) {
            $data['cierre'] = new DateTime('now');
        }

        return ProcesosCargos::create($data);
    }

    /**
     * @param int $proceso <i>id</i> de proceso
     * @param int $cargo <i>id</i> de cargo
     * @param int $user <i>id</i> de usuario
     * @return void
     */
    public function actualizar(int $proceso, int $cargo, int $user, $cierre_modulo = true): void
    {
        $pc = $this->getProcesoCargo($proceso, $cargo);

        if (!$pc) {
            $this->crear($proceso, $cargo, $user);
        }
        $this->cierraProcesoCargo($cargo, $proceso, $user, true, $cierre_modulo);
    }

    /**
     * @param int $cargo
     * @param int $proceso
     * @param int $user
     * @param bool $cierra
     * @param bool $cierre_modulo
     * @return void
     */
    public function cierraProcesoCargo(
        int $cargo, int $proceso, int $user, bool $cierra = false, bool $cierre_modulo = true
    ): void
    {
        $pc = $this->getProcesoCargo($proceso, $cargo);

        if (!$pc) {
            $pc = $this->crear($proceso, $cargo, $user);
        }
        if ($cierra) {
            $pc->cierre = new DateTime('now');
        }
        $pm = ProcesoModular::where([
            'proceso_id' => $proceso,
        ])->first();

        $pms = new ProcesoModularService();

        $pms->grabaEstadoPorProcesoModular($pm);

        // Esta parte debería estar como método aparte
        $nota_tfi = $pm->trabajo_final_nota;
        $nota_pf = $pm->promedio_final_nota;
        $nota_final = $nota_pf * 0.8 + $nota_tfi * 0.2;

        $pm->nota_final_nota = $nota_final;
        $pm->update();

        $procesoService = new ProcesoService();
        if($cierre_modulo) {
            $procesoService->cierraProcesoDesdeModular($proceso);
        }

        $pc->operador_id = $user;
        $pc->update();
    }

    /**
     * @param int $proceso
     * @param int $cargo
     * @return ProcesosCargos
     */
    protected
    function getProcesoCargo(int $proceso, int $cargo)
    {
        return ProcesosCargos::where([
            'proceso_id' => $proceso,
            'cargo_id' => $cargo,
        ])->first();
    }
}
