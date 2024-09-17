<?php

namespace App\Repository\LibroDigital;

use App\Models\FolioNota;
use App\Models\Materia;

class FolioNotaRepository
{
    public function getFoliosNotaForAlumnoByMateria($alumno, Materia $materia, $cohorte =  null)
    {

        $foliosNota = FolioNota::join('mesa_folios', 'mesa_folios.id', 'folio_notas.mesa_folio_id')
            ->where('mesa_folios.master_materia_id', $materia->master_materia_id)
            ->where('alumno_id', $alumno);

        if ($cohorte) {
            $foliosNota->whereYear('mesa_folios.fecha', '>=', $cohorte);
        }

        return $foliosNota->get();

    }

}
