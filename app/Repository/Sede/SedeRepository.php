<?php

namespace App\Repository\Sede;

use App\Models\LibroDigital;
use App\Models\LibroPapel;
use App\Models\Materia;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Models\User;

class SedeRepository
{
    public function getResolucionesSedes(array $sede)
    {
        return Resoluciones::select( 'resoluciones.*', )
            ->join('carreras', 'resoluciones.id', '=', 'carreras.resolucion_id')
            ->join('sedes', 'carreras.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->distinct()
            ->orderBy('resoluciones.name')
            ->get();
    }

    public function getLibrosPapelSedes(array $sede)
    {
        return LibroPapel::select( 'libros_papeles.*', )
            ->join('sedes', 'libros_papeles.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->distinct()
            ->get();
    }

    public function getLibrosDigitalesSedes(array $sede)
    {
        return LibroDigital::select( 'libros_digitales.*', )
            ->join('sedes', 'libros_digitales.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->distinct()
            ->get();
    }

    public function getUsersSedes($sede = [])
    {
        return User::join('sede_user', 'sede_user.user_id', '=', 'users.id')
            ->whereIn('sede_user.sede_id', $sede)
            ->distinct()
//            ->groupBy('users.id')
            ->get();
    }

    public function getMateriasSedes(array $sede)
    {
        return Materia::select( 'materias.*', )
            ->join('carreras', 'materias.carrera_id', '=', 'carreras.id')
            ->join('sedes', 'carreras.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->groupBy('materias.id')
            ->get();
    }
}
