<?php

namespace App\Repository\LibroDigital;

use App\Models\FolioNota;
use App\Models\Materia;
use Barryvdh\Reflection\DocBlock\Type\Collection;
use LaravelIdea\Helper\App\Models\_IH_FolioNota_C;

class FolioNotaRepository
{
    /**
     * @param $alumno
     * @param Materia $materia
     * @param null $cohorte
     * @return FolioNota[]|Collection
     */
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

    /**
     * @param int $acta_volante
     * @return FolioNota|null
     */
    public function getFolioByActaVolante(int $acta_volante): ?FolioNota
    {
        return FolioNota::where('acta_volante_id', $acta_volante)->first();
    }

}
