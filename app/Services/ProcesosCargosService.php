<?php

namespace App\Services;

use App\Models\ProcesoModular;
use App\Models\ProcesosCargos;

class ProcesosCargosService{

    public function crear(int $proceso, int $cargo, int $user ){

        $data['proceso_id'] = $proceso;
        $data['cargo_id'] = $cargo;
        $data['operador_id'] = $user;
        $data['cierre'] =  new \DateTime('now');

            ProcesosCargos::create($data);

    }

    /**
     * @param int $proceso <i>id</i> de proceso
     * @param int $cargo <i>id</i> de cargo
     * @param int $user <i>id</i> de usuario
     * @return void
     */
    public function actualizar(int $proceso, int $cargo, int $user){

        $pc = $this->getProcesoCargo($proceso, $cargo);

        if($pc){
            $this->cierraProcesoCargo($cargo, $proceso, $user);
        }else{
            $this->crear($proceso, $cargo, $user);
        }
    }

    /**
     * @param int $cargo
     * @param int $proceso
     * @param int $user
     * @param bool $cierra
     * @return void
     */
    public function cierraProcesoCargo(int $cargo, int $proceso, int $user, bool $cierra = false): void
    {
        $pc = $this->getProcesoCargo($proceso, $cargo);

        if ($pc->isClose() and !$cierra) {
            $pc->cierre = null;
        } else {
            $pc->cierre = new \DateTime('now');

            $pm = ProcesoModular::where([
                'proceso_id' => $proceso,
            ])->first();

            $pms = new ProcesoModularService();

            $pms->grabaEstadoPorProcesoModular($pm);


        };
        $pc->operador_id = $user;
        $pc->update();
    }

    /**
     * @param int $proceso
     * @param int $cargo
     * @return mixed
     */
    protected function getProcesoCargo(int $proceso, int $cargo)
    {
        return ProcesosCargos::where([
            'proceso_id' => $proceso,
            'cargo_id' => $cargo,
        ])->first();
    }
}