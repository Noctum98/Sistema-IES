<?php

namespace App\Services;

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

        $pc = ProcesosCargos::where([
           'proceso_id'=>$proceso,
           'cargo_id'=>$cargo,
        ])->first();

        if($pc){
            if($pc->isClose()){
                $pc->cierre = null;
            }else{
                $pc->cierre = new \DateTime('now');
            };
            $pc->operador_id =  $user;
            $pc->update();
        }else{
            $this->crear($proceso, $cargo, $user);
        }
    }
}