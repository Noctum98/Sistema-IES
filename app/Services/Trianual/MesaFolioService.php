<?php

namespace App\Services\Trianual;

use App\Models\Libro;
use App\Models\LibroDigital;
use App\Models\Mesa;
use App\Models\MesaFolio;

class MesaFolioService
{
    private LibroDigitalService $libroDigitalService;

    public function __construct(LibroDigitalService $libroDigitalService)
    {
        $this->libroDigitalService = $libroDigitalService;
    }

    public function cargaMesaFolioByLibroDigitalMesaLibroFolio(LibroDigital $libroDigital, Mesa $mesa, Libro $libro, $user):MesaFolio
    {
        $mesaFolio = MesaFolio::where([
            'libro_digital_id' => $libroDigital->id,
            'folio' => $libro->folio,
        ])->first();

        if (!$mesaFolio) {
            $desglose = $libro->getResultadosActasVolantes();
            dd($desglose);

            $mesaFolio = $this->setMesaFolio($desglose, $libroDigital, $mesa, $libro, $user);
        }

        return $mesaFolio;

    }

    /**
     * @param array $desglose
     * @param LibroDigital $libroDigital
     * @param Mesa $mesa
     * @param Libro $libro
     * @param $user
     * @return MesaFolio
     */
    public function setMesaFolio(array $desglose, LibroDigital $libroDigital, Mesa $mesa, Libro $libro, $user): MesaFolio
    {
        [$fecha, $presidente, $vocal_1, $vocal_2] = $this->libroDigitalService->getDataMesa($mesa, $libro);

        return MesaFolio::create([
            'aprobados' => $desglose['aprobados'],
            'ausentes' => $desglose['ausentes'],
            'desaprobados' => $desglose['desaprobados'],
            'coordinador_id' => null,
            'fecha' => date('Y-m-d', strtotime($fecha)),
            'libro_digital_id' => $libroDigital->id,
            'master_materia_id' => $mesa->materia->master_materia_id,
            'mesa_id' => $mesa->id,
            'folio' => $libro->folio,
            'operador_id' => $user->id,
            'presidente_id' => $presidente,
            'turno' => null,
            'llamado' => $libro->llamado,
            'vocal_1_id' => $vocal_1,
            'vocal_2_id' => $vocal_2,
        ]);
    }
}
