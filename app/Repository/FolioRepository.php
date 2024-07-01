<?php

namespace App\Repository;

use App\Models\FolioNota;
use App\Models\MesaFolio;

class FolioRepository
{
    public function getFoliosByLibrosDigitales($librosDigitales = [])
    {

        return MesaFolio::select('mesa_folios.*')
            ->whereIn('libro_digital_id', $librosDigitales)
            ->get();
    }
}
