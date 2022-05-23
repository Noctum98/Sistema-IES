<?php

namespace App\Services;

use App\Models\User;

class UserService{
    public function buscador($busqueda,$rol=null)
    {
        $lista = User::where(function($query) use ($busqueda){
            $query-> where('username', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('nombre', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('apellido', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('email', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('telefono', 'LIKE', '%' . $busqueda . '%');
        });
        
        if($rol)
        {
            $lista->whereHas('roles',function($query) use ($rol){
                return $query->where('nombre',$rol);
            });
        }

        return $lista->paginate(10);
    }
}