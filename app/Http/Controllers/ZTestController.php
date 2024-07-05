<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\LibroDigital;
use App\Models\MasterMateria;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\MesaFolio;
use App\Models\Regimen;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Services\AlumnoService;
use App\Services\CicloLectivoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ZTestController extends Controller
{

    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin');


    }

    public function getActions(string $name)
    {
        $resolucion = Resoluciones::with('carreras.materias')
            ->where('id', $name)
            ->get();

        foreach ($resolucion as $resoluciones) {
            foreach ($resoluciones->carreras as $carreras) {
                foreach ($carreras->materias as $materia) {
                    $data = [];

                    /** @var Materia $materia */
                    $data['name'] = $materia->nombre;
                    $data['year'] = $materia->año;
                    $data['field_stage'] = $materia->etapa_campo;
                    $data['delayed_closing'] = $materia->cierre_diferido;
                    $data['resoluciones_id'] = $resoluciones->id;
                    $data['regimen_id'] = $this->getRegimen($materia->regimen);

                    $mm = MasterMateria::where('name', $data['name'])->first();

                    if (!$mm) {

                        $mm = MasterMateria::create($data);

                    }

                    $materia->master_materia_id = $mm->id;
                    $materia->save();
                }
            }
        }

        return $resolucion;
    }

    public function getRegimen(string $regimen = null)
    {

        switch ($regimen) {
            case Materia::ANUAL:
                $id = Regimen::where(['identifier' => 'anual'])->first()->id;
                break;
            case Materia::PRI_SEM:
                $id = Regimen::where(['identifier' => 'sem_1'])->first()->id;
                break;
            case Materia::SEC_SEM:
                $id = Regimen::where(['identifier' => 'sem_2'])->first()->id;
                break;
            default:
                $id = Regimen::where(['identifier' => 'anual'])->first()->id;
        }

        return $id;

    }

    public function cargaLibros(Sede $sede)
    {

        $user = auth()->user();

        $mesas = $sede->getMesas();

        $data = [];
        $data['user_id'] = $user->id;
        $data['sede_id'] = $sede->id;

        foreach ($mesas as $mesa) {

            /** @var Mesa $mesa */
            $resolucion_id = $mesa->materia->masterMateria->resoluciones->id;
            $masterMateria = $mesa->materia->master_materia_id;
            $data['resoluciones_id'] = $resolucion_id;
            if ($mesa->libros()->count() > 0) {
                foreach ($mesa->libros()->get() as $libro) {

                    /** @var Libro $libro */
                    $numero = $libro->numero;

                    $folio = $libro->folio;
                    $romano = $mesa->libro;
                    $fecha = $mesa->fecha;
                    $presidente = $mesa->presidente_id;
                    $vocal_1 = $mesa->primer_vocal_id;
                    $vocal_2 = $mesa->segundo_vocal_id;

                    if ($libro->llamado > 2) {
                        $romano = $mesa->libro_segundo;
                        $folio = $mesa->folio_segundo;
                        $fecha = $mesa->fecha_segundo;
                        $presidente = $mesa->presidente_segundo_id;
                        $vocal_1 = $mesa->primer_vocal_segundo_id;
                        $vocal_2 = $mesa->segundo_vocal_segundo_id;
                    }

                    if ($numero && $romano) {

                        $fecha = date('Y-m-d', strtotime($fecha));

                        $data['number'] = $numero;
                        $data['romanos'] = $romano;
                        $data['resoluciones_id'] = $resolucion_id;

                        $libroDigital = LibroDigital::where(
                            [
                                'resoluciones_id' => $resolucion_id,
                                'number' => $numero,
                                'sede_id' => $sede->id,
                            ]
                        )->first();

                        if (!$libroDigital) {
                            $libroDigital = LibroDigital::create(
                                $data
                            );
                        }

                        $mesaFolio = $libroDigital->mesaFolios()->where('numero', $folio)->first();

                        if (!$mesaFolio) {
                            $mesaFolio = MesaFolio::create(
                                [
                                    'fecha' => $fecha,
                                    'libro_digital_id' => $libroDigital->id,
                                    'master_materia_id' => $masterMateria,
                                    'mesa_id' => $mesa->id,
                                    'numero' => $folio,
                                    'operador_id' => $user->id,
                                    'presidente_id' => $presidente,
                                    'vocal_1_id' => $vocal_1,
                                    'vocal_2_id' => $vocal_2,
                                ]
                            );

                        }
                    }

                }
            }
        }

        return response()->json([
            'sede' => $sede->nombre,
            'mesas' => $mesas->count()
        ]);

    }

}






