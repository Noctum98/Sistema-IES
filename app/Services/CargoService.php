<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\User;

class CargoService
{
    public function buscador($busqueda,$paginate = false)
    {
        $cargos = new Cargo();
        if($busqueda['nombre'] && $busqueda['nombre'] != ''){
            $cargos = $cargos->where('nombre','LIKE','%'.$busqueda['nombre'].'%');
        }

        if($busqueda['carrera_id']  && $busqueda['carrera_id'] != 'todos')
        {
            $cargos->where('carrera_id',$busqueda['carrera_id']);
        }

        if($paginate)
        {
            return $cargos->paginate(10);
        }else{
            return $cargos->get();
        }
    }


    public function buscadorCargo($busqueda)
    {
        return Cargo::select('id', 'nombre')->where('nombre', $busqueda)->get();
    }
}
