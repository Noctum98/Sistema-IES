<?php

namespace App\Services\Trianual;

use App\Models\ActaVolante;
use App\Models\FolioNota;
use App\Models\Libro;
use App\Models\MesaFolio;

class FolioNotasService
{
    private LibroDigitalService $libroDigitalService;

    public function __construct(LibroDigitalService $libroDigitalService)
    {
        $this->libroDigitalService = $libroDigitalService;
    }

    /**
     * @param Libro $libro
     * @param MesaFolio $mesaFolio
     * @param $user
     * @return void
     */
    public function cargaNotas(Libro $libro, MesaFolio $mesaFolio, $user): void
    {


        $actas = $libro->obtenerActasVolantes();


        $orden = 0;
        foreach ($actas as $acta) {
            /** @var ActaVolante $acta */
            $orden++;

            $folioNota = FolioNota::where([
                    'alumno_id' => $acta->alumno_id,
                    'acta_volante_id' => $acta->id,
                    'mesa_folio_id' => $mesaFolio->id
                ]
            )->first();

            if (!$folioNota) {
                $escrito = $this->libroDigitalService->getGenericService()->findNumber($acta->nota_escrito);
                $oral = $this->libroDigitalService->getGenericService()->findNumber($acta->nota_oral);
                $definitiva = $this->libroDigitalService->getGenericService()->findNumber($acta->promedio);

                $folioNota = FolioNota::create([
                    'orden' => $orden,
                    'permiso' => null,
                    'escrito' => $escrito,
                    'oral' => $oral,
                    'definitiva' => $definitiva,
                    'operador_id' => $user->id,
                    'acta_volante_id' => $acta->id,
                    'mesa_folio_id' => $mesaFolio->id,
                    'alumno_id' => $acta->alumno_id,
                ]);
            }


        }
    }
}
