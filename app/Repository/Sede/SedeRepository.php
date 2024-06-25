<?php

namespace App\Repository\Sede;

use App\Models\LibroPapel;
use App\Models\Resoluciones;
use App\Models\Sede;

class SedeRepository
{
    public function getResolucionesSedes(array $sede)
    {
        return Resoluciones::select( 'resoluciones.*', )
            ->join('carreras', 'resoluciones.id', '=', 'carreras.resolucion_id')
            ->join('sedes', 'carreras.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->groupBy('resoluciones.id')
            ->get();
    }

    public function getLibrosPapelSedes(array $sede)
    {
        return LibroPapel::select( 'libros_papeles.*', )
            ->join('sedes', 'libros_papeles.sede_id', '=', 'sedes.id')
            ->whereIn('sedes.id', $sede)
            ->groupBy('libros_papeles.id')
            ->get();
    }
}
