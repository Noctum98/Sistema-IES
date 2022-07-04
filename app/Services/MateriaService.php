<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\Materia;
use App\Models\User;

class MateriaService
{
    public function buscador($busqueda,$paginate = false)
    {
        $materias = Materia::select('cargos.*');

        if($busqueda['nombre'] && $busqueda['nombre'] != ''){
            $materias = $materias->where('nombre','LIKE','%'.$busqueda['nombre'].'%');
        }



        if($paginate)
        {
            return $materias->paginate(30);
        }else{
            return $materias->get();
        }
    }


    public function buscadorMateria($busqueda)
    {
        return Materia::select('id', 'nombre')->where('nombre', $busqueda)->get();
    }
}
