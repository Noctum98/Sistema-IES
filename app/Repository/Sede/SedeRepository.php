<?php

namespace App\Repository\Sede;

use App\Models\LibroDigital;
use App\Models\LibroPapel;
use App\Models\Materia;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Support\Collection;
use LaravelIdea\Helper\App\Models\_IH_User_C;

class SedeRepository
{
    public function getResolucionesSedes(array $sede)
    {
        return Resoluciones::select('resoluciones.*',)
            ->join('carreras', 'resoluciones.id', '=', 'carreras.resolucion_id')
            ->join('sedes', 'carreras.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->distinct()
            ->orderBy('resoluciones.name')
            ->get();
    }

    public function getLibrosPapelSedes(array $sede)
    {
        return LibroPapel::select('libros_papeles.*',)
            ->join('sedes', 'libros_papeles.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->distinct()
            ->get();
    }

    public function getLibrosDigitalesSedes(array $sede)
    {
        return LibroDigital::select('libros_digitales.*',)
            ->join('sedes', 'libros_digitales.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->distinct()
            ->get();
    }


    /**
     * @param array $sede
     * @return User[]|null
     */
    public function getUsersSedes(array $sede = []): ?Collection
    {
        return User::join('sede_user', 'sede_user.user_id', '=', 'users.id')
            ->whereIn('sede_user.sede_id', $sede)
            ->distinct()
//            ->groupBy('users.id')
            ->get();
    }


    public function getProfesoresSede($sede)
    {
        return User::select('users.*')
            ->join('rol_user', 'rol_user.user_id', '=', 'users.id')
            ->join('sede_user', 'sede_user.user_id', '=', 'users.id')
            ->where('rol_user.rol_id', 15)
            ->whereIn('sede_user.sede_id', $sede)
            ->distinct()
            ->get();
    }

    public function getMateriasSedes(array $sede)
    {
        return Materia::select('materias.*',)
            ->join('carreras', 'materias.carrera_id', '=', 'carreras.id')
            ->join('sedes', 'carreras.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->groupBy('materias.id')
            ->get();
    }
}
