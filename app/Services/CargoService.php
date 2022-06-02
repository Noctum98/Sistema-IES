<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\User;

class CargoService
{
    public function buscador($busqueda)
    {
        $lista = Cargo::where(function ($query) use ($busqueda){
            $query->join('carreras', 'carrera_id', '=', 'cargos.carrera_id')
            ->where('cargos.nombre', 'LIKE', '%'.$busqueda.'%')
//            ->orWhere('cargo.carrera.nombre', 'LIKE', '%'.$busqueda.'%');
//        $lista->whereHas('carrera',function($query) use ($busqueda){
//            return $query->orWhere('nombre', 'LIKE', '%' . $busqueda . '%');
//        });
            ;
    });

        return $lista->paginate(10);
    }


    public function buscadorCargo($busqueda)
    {
        return Cargo::select('id', 'nombre')->where('nombre', $busqueda)->get();
    }
}
