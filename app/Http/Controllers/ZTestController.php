<?php

namespace App\Http\Controllers;

use App\Handler\GenericHandler;
use App\Models\ActaVolante;
use App\Models\FolioNota;
use App\Models\Libro;
use App\Models\LibroDigital;
use App\Models\MasterMateria;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\MesaFolio;
use App\Models\Regimen;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ZTestController extends Controller
{

    private GenericHandler $handler;

    /**
     * @param GenericHandler $handler
     */
    public function __construct(GenericHandler $handler)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin');


        $this->handler = $handler;
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

    public function updateRegimenes(): string
    {
        $resoluciones = Resoluciones::all();

        foreach ($resoluciones as $resolucion) {
            foreach ($resolucion->carreras as $carrera) {
                foreach ($carrera->materias as $materia) {
                    $masterMateria = $materia->masterMateria;
                    $masterMateria->regimen_id = $this->getRegimen($materia->regimen);
                    $masterMateria->update();
                }
            }
        }

        return 'Master materias actualizadas';

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

    /**
     * @param Sede $sede
     * @return JsonResponse
     * @ruta /z_test/carga_libros/{sedes_id}
     */
    public function cargaLibros(Sede $sede): JsonResponse
    {
        $user = auth()->user();
        $mesas = $sede->getMesas();
        $libros = Libro::whereHas('mesa.materia.carrera.sede', static function ($query) use ($sede) {
            $query->where('id', $sede->id);
        })->get();

        $error = [];

        foreach ($libros as $libro) {
            /** @var Libro $libro */

            /** @var Mesa $mesa */
            $mesa = $libro->mesa()->first();

            if ($mesa && $mesa->materia && $mesa->materia->masterMateria && $libro->actasVolantes && $libro->actasVolantes->count() > 0) {


                $resolucion_id = $mesa->materia->masterMateria->resoluciones->id;
                $numero = $libro->numero;
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
                            'fecha_inicio' => null,
                            'sede_id' => $sede->id,
                            'libros_papeles_id' => null,
                            'observaciones' => 'Creado por DATA IESVU',
                            'operador_id' => null,
                            'user_id' => $user->id]
                    );
                }

                $mesaFolio = MesaFolio::where([
                    'libro_digital_id' => $libroDigital->id,
                    'mesa_id' => $libro->mesa_id,
                    'folio' => $libro->folio,
                ])->first();

                if (!$mesaFolio) {
                    $desglose = $libro->getResultadosActasVolantes();

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

                    $existPresidente = User::where('id', $presidente)->first();
                    $exist1 = User::where('id', $vocal_1)->first();
                    $exist2 = User::where('id', $vocal_2)->first();

                    if (!$existPresidente || !$exist1 || !$exist2) {
                        dd($mesa, $presidente, $vocal_1, $vocal_2);
                    }


                    $mesaFolio = MesaFolio::create([
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
                        $escrito = $this->findNumber($acta->nota_escrito);
                        $oral = $this->findNumber($acta->nota_oral);
                        $definitiva = $this->findNumber($acta->promedio);

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

            } else {
                $error[] = [
                    'Mesa' => $mesa->id,
                    'Caso' => 'Mesa sin libro ni actas volantes'
                ];
            }

        }

        return response()->json([
            'sede' => $sede->nombre,
            'mesas' => $mesas->count(),
            'libros' => $libros->count(),
            'error' => $error
        ]);

    }

    /**
     * @param $str
     * @return string|null
     */
    private function findNumber($str): ?string
    {
        if ($str === '-') {
            return null;
        }
        preg_match('/\d+/', $str, $matches);
        return $matches[0] ?? null;
    }

}
