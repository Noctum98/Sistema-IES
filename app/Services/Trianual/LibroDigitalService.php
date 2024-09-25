<?php

namespace App\Services\Trianual;

use App\Handler\GenericHandler;
use App\Models\ActaVolante;
use App\Models\FolioNota;
use App\Models\Libro;
use App\Models\LibroDigital;
use App\Models\Mesa;
use App\Models\MesaFolio;
use App\Models\User;
use App\Services\GenericService;

class LibroDigitalService
{

    private GenericHandler $handler;
    private GenericService $genericService;

    /**
     * @param GenericHandler $handler
     * @param GenericService $genericService
     */
    public function __construct(GenericHandler $handler, GenericService $genericService)
    {
        $this->handler = $handler;
        $this->genericService = $genericService;
    }

    /**
     * @param Libro $libro
     * @param $user
     * @return void
     */
    public function cargaLibroDigitaByLibro(Libro $libro, $user): void
    {
        /** @var Mesa $mesa */
        $mesa = $libro->mesa()->first();
        if (!$mesa) {
            session()->flash(
                'error',
                "El libro $libro->id - $libro->numero - $libro->folio
                no tiene mesa cargada. Por favor verifique los datos cargados"
            );
            return;
        }

        if (!$mesa->materia->master_materia_id) {
            session()->flash(
                'error',
                "La materia {$mesa->materia->nombre}  no tiene MasterMateria cargada. Por favor avise al Equipo Data"
            );
            return;
        }

        $resolucion_id = $mesa->materia->masterMateria->resoluciones->id;
        $numero = $libro->numero;
        $sede = $mesa->materia->carrera->sede;
        $libroDigital = LibroDigital::where(
            [
                'resoluciones_id' => $resolucion_id,
                'number' => $numero,
                'sede_id' => $sede->id,
            ]
        )->first();

        if (!$libroDigital) {
            $romano = $mesa->libro ?? $this->handler->convertirNumberToRoman($numero);

            $libroDigital = LibroDigital::create([
                    'acta_inicio' => null,
                    'number' => $numero,
                    'romanos' => $romano,
                    'resoluciones_id' => $resolucion_id,
                    'sede_id' => $sede->id,
                    'libros_papeles_id' => null,
                    'observaciones' => '',
                    'operador_id' => null,
                    'user_id' => $user->id]
            );
        }


        if ($libro->folio === "1") {
            $fechaInicio = date('Y-m-d', strtotime($mesa->fecha));
            $libroDigital->fecha_inicio = $fechaInicio;
            $libroDigital->save();
        }


        $mesaFolio = MesaFolio::where([
            'libro_digital_id' => $libroDigital->id,
            'mesa_id' => $libro->mesa_id,
            'folio' => $libro->folio,
        ])->first();

        if (!$mesaFolio) {
            $desglose = $libro->getResultadosActasVolantes();

            $mesaFolio = $this->setMesaFolio($desglose, $libroDigital, $mesa, $libro);
        }

        $actas = $libro->getActasVolantes();

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
                $escrito = $this->genericService->findNumber($acta->nota_escrito);
                $oral = $this->genericService->findNumber($acta->nota_oral);
                $definitiva = $this->genericService->findNumber($acta->promedio);

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

    public function actualizaLibroDigitaByLibro(Libro $libroAnterior, Libro $libro, $user): void
    {


        /** @var Mesa $mesa */
        $mesa = $libro->mesa()->first();
        if (!$mesa) {
            session()->flash(
                'error',
                "El libro $libro->id - $libro->numero - $libro->folio
                no tiene mesa cargada. Por favor verifique los datos cargados"
            );

            return;
        }



        if (!$mesa->materia->master_materia_id) {
            session()->flash(
                'error',
                "La materia {$mesa->materia->nombre}  no tiene MasterMateria cargada. Por favor avise al Equipo Data"
            );
            return;
        }



        $resolucion_id = $mesa->materia->masterMateria->resoluciones->id;
        $numero = $libroAnterior->numero;
        $sede = $mesa->materia->carrera->sede;


        $libroDigital = LibroDigital::where(
            [
                'resoluciones_id' => $resolucion_id,
                'number' => $numero,
                'sede_id' => $sede->id,
            ]
        )->first();


        if (!$libroDigital) {
            session()->flash(
                'error',
                "El libro $libro->id - $libroAnterior->numero - $libroAnterior->folio
                no pudo actualizar el libro de actas. Por favor verifique los datos cargados"
            );
            return;
        }

        $romano = $this->handler->convertirNumberToRoman($libro->numero);
        $fechaInicio = null;
        if ($libro->folio === "1") {
            $fechaInicio = date('Y-m-d', strtotime($mesa->fecha));
        }
        /** @var User $user */
        $libroDigital->update([
                'number' => $libro->numero,
                'romanos' => $romano,
                'observaciones' => $libroDigital->observaciones . ' - Edición libro/folio ' . $user->getApellidoNombre(),
                'user_id' => $user->id,
                'fecha_inicio' => $fechaInicio
            ]
        );


        $mesaFolio = MesaFolio::where([
            'libro_digital_id' => $libroDigital->id,
            'mesa_id' => $libro->mesa_id,
            'folio' => $libroAnterior->folio,
        ])->first();

        $desglose = $libro->getResultadosActasVolantes();

        if ($mesaFolio) {
            $this->updateMesaFolio($desglose, $mesaFolio, $mesa, $libro);
        }else{
            $mesaFolio = $this->setMesaFolio($desglose, $libroDigital, $mesa, $libro);
        }

        $actas = $libro->getActasVolantes();

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
                $escrito = $this->genericService->findNumber($acta->nota_escrito);
                $oral = $this->genericService->findNumber($acta->nota_oral);
                $definitiva = $this->genericService->findNumber($acta->promedio);

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


    /**
     * @param array $desglose
     * @param LibroDigital $libroDigital
     * @param Mesa $mesa
     * @param Libro $libro
     * @return MesaFolio
     */
    public function setMesaFolio(array $desglose, LibroDigital $libroDigital, Mesa $mesa, Libro $libro): MesaFolio
    {
        [$fecha, $presidente, $vocal_1, $vocal_2] = $this->getDataMesa($mesa, $libro);

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
            'operador_id' => null,
            'presidente_id' => $presidente,
            'turno' => null,
            'llamado' => $libro->llamado,
            'vocal_1_id' => $vocal_1,
            'vocal_2_id' => $vocal_2,
        ]);
    }

    /**
     * @param array $desglose
     * @param MesaFolio $mesaFolio
     * @param Mesa $mesa
     * @param Libro $libro
     * @return MesaFolio
     */
    public function updateMesaFolio(array $desglose, MesaFolio $mesaFolio,Mesa $mesa, Libro $libro): MesaFolio
    {
        [$fecha, $presidente, $vocal_1, $vocal_2] = $this->getDataMesa($mesa, $libro);

         $mesaFolio->update([
            'aprobados' => $desglose['aprobados'],
            'ausentes' => $desglose['ausentes'],
            'desaprobados' => $desglose['desaprobados'],
            'fecha' => date('Y-m-d', strtotime($fecha)),
            'folio' => $libro->folio,
            'presidente_id' => $presidente,
            'llamado' => $libro->llamado,
            'vocal_1_id' => $vocal_1,
            'vocal_2_id' => $vocal_2,
        ]);

         return $mesaFolio;
    }

    /**
     * @param Mesa $mesa
     * @param $libro
     * @return array
     */
    public function getDataMesa(Mesa $mesa, $libro): array
    {
        $fecha = $mesa->fecha;

        $presidente = $mesa->presidente_id;
        $vocal_1 = $mesa->primer_vocal_id;
        $vocal_2 = $mesa->segundo_vocal_id;

        if ($libro->llamado > 2) {

            $fecha = $mesa->fecha_segundo;
            $presidente = $mesa->presidente_segundo_id;
            $vocal_1 = $mesa->primer_vocal_segundo_id;
            $vocal_2 = $mesa->segundo_vocal_segundo_id;
        }
        return array($fecha, $presidente, $vocal_1, $vocal_2);
    }

}
