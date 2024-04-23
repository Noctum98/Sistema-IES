<?php

namespace App\Services;

use App\Models\Carrera;
use App\Models\Mesa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserService
{
    public function buscador($busqueda, $rol = null)
    {
        $lista = User::where(function ($query) use ($busqueda) {
            $query->where('username', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('nombre', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('apellido', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('email', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('telefono', 'LIKE', '%' . $busqueda . '%');
        });

        if ($rol) {
            $lista = $lista->whereHas('roles', function ($query) use ($rol) {
                return $query->where('nombre', $rol);
            });
        }


        $lista = $lista->whereDoesntHave('roles', function ($query) {
            return $query->where('nombre', 'alumno');
        });


        return $lista->paginate(10);
    }


    public function buscadorUsuario($busqueda)
    {

        return User::select('id', 'nombre', 'apellido')->withTrashed()->where('username', $busqueda)->with('alumnoOne')->get();
    }

    public function listadoRol($rol, $sede = false, $carrera = false, $paginate = false)
    {
        $users = User::whereHas('roles', function ($query) use ($rol) {
            return $query->where('roles.nombre', $rol);
        });

        if ($sede) {
            $users->whereHas('sedes', function ($query) use ($sede) {
                return $query->where('sedes.id', $sede);
            });
        }

        if ($carrera) {
            $users->whereHas('carreras', function ($query) use ($carrera) {
                return $query->where('carreras.id', $carrera);
            });
        }

        if ($paginate) {
            return $users->paginate(10);
        } else {
            return $users->get();
        }
    }

    public function mesasPresidente()
    {
        $user = Auth::user();
        $mesas = Mesa::where('presidente_id', $user->id)
    ->orWhere('presidente_segundo_id', $user->id)
    ->orderBy('id', 'DESC')
    ->paginate(10);

        /*
            Mesa::select('mesas.*','instancias.nombre','instancias.año','carreras.nombre')
            ->join('instancias','instancias.id','mesas.instancia_id')
            ->join('carreras','carreras.id','mesas.carrera_id')
            ->where('mesas.presidente_id','=',$user->id)
            ->where('instancias.estado','=','activa')->get();
        */

        return $mesas;
    }
    public function getUserById(int $idUser): User
    {
        return User::find($idUser);
    }

    /**
     * @return array
     */
    public function getCarreras(): array
    {
        $user = Auth::user();

        if (Session::has('admin') || Session::has('regente') || Session::has('areaSocial')) {
            $carreras = Carrera::orderBy('sede_id')->get();
        }
        else{
            $carreras = $user->carreras;
        }


        return array($user, $carreras);
    }
}
