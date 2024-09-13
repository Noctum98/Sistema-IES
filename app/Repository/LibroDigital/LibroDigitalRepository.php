<?php

namespace App\Repository\LibroDigital;

use App\Models\Carrera;
use App\Models\LibroDigital;
use App\Models\Resoluciones;

class LibroDigitalRepository
{
    public function getLibrosBySedeResolution($sede_id, $resolution_id)
    {

        return LibroDigital::where('sede_id', $sede_id)
            ->where('resoluciones_id', $resolution_id)
            ->orderBy('resoluciones_id')
            ->orderBy('number')
            ->paginate(25)
            ;

    }

}
