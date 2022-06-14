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


            $lista->whereDoesntHave('roles', function ($query) {
                return $query->where('nombre', 'alumno');
            });


        return $lista->paginate(10);
    }


    public function buscadorUsuario($busqueda)
    {

        return User::select('id', 'nombre', 'apellido')->where('username', $busqueda)->get();

    }

    public function listadoRol($rol,$sede = false,$carrera = false,$paginate = false)
    {
        $users = User::whereHas('roles',function($query) use ($rol){
            return $query->where('roles.nombre',$rol);
        });

        if($sede)
        {
            $users->whereHas('sedes',function($query) use ($sede){
                return $query->where('sedes.id',$sede);
            });
        }

        if($carrera)
        {
            $users->whereHas('carreras',function($query) use ($carrera){
                return $query->where('carreras.id',$carrera);
            });
        }


        if($paginate)
        {
            return $users->paginate(10);
        }else{
            return $users->get();
        }
    }
}
