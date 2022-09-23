<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Proceso;
use App\Models\ProcesosCargos;
use Illuminate\Support\Facades\Auth;


class ProcesosCargosService{
    public function crear(int $proceso, int $cargo, int $user ){

        $data['proceso_id'] = $proceso;
        $data['cargo_id'] = $cargo;
        $data['operador_id'] = $user;
        $data['cierre'] =  new \DateTime('now');
//dd($data['cierre']);

            ProcesosCargos::create($data);

    }

    public function update(int $proceso, int $cargo, int $user){

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