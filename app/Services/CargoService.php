<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\User;

class CargoService
{
    public function buscador($busqueda,$paginate = false)
    {
        $cargos = Cargo::select('cargos.*');

        if($busqueda['nombre'] && $busqueda['nombre'] != ''){
            $cargos = $cargos->where('nombre','LIKE','%'.$busqueda['nombre'].'%');
        }

        if($busqueda['carrera_id']  && $busqueda['carrera_id'] != 'todos')
        {
            $cargos->where('carrera_id',$busqueda['carrera_id']);
        }

        if($paginate)
        {
            return $cargos->paginate(30);
        }else{
            return $cargos->get();
        }
    }


    public function buscadorCargo($busqueda)
    {
        return Cargo::select('id', 'nombre')->where('nombre', $busqueda)->get();
    }

    /**
     * @param $cargo
     * @param $materia
     * @return mixed
     */
    public function getPonderacion($cargo, $materia)
    {
        $ponderacion = 0;
        $cargo_materia = CargoMateria::where([
            'cargo_id' => $cargo,
            'materia_id' => $materia
        ])->first();
        if($cargo_materia){
            $ponderacion = $cargo_materia->ponderacion;
        }

        return $ponderacion;
    }
}
