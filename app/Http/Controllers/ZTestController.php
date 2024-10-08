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
use App\Services\GenericService;
use App\Services\Trianual\LibroDigitalService;
use Illuminate\Http\JsonResponse;

class ZTestController extends Controller
{

    private GenericHandler $handler;
    private LibroDigitalService $libroDigitalService;
    private GenericService $genService;

    /**
     * @param GenericHandler $handler
     * @param LibroDigitalService $libroDigitalService
     */
    public function __construct(GenericHandler $handler, LibroDigitalService $libroDigitalService)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin');


        $this->handler = $handler;
        $this->libroDigitalService = $libroDigitalService;
        $this->genService = new GenericService();
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

                    [$presidente, $vocal_1, $vocal_2] = $this->libroDigitalService->getDataMesa($mesa, $libro);

                    $existPresidente = true;
                    $exist1 = true;
                    $exist2 = true;
                    if ($presidente !== null) {
                        $existPresidente = User::where('id', $presidente)->first();
                    }
                    if ($vocal_1 !== null) {
                        $exist1 = User::where('id', $vocal_1)->first();
                    }
                    if ($vocal_2 !== null) {
                        $exist2 = User::where('id', $vocal_2)->first();
                    }

                    if (!$existPresidente || !$exist1 || !$exist2) {
                        dd($mesa, $presidente, $vocal_1, $vocal_2);
                    }

                    $mesaFolio = $this->libroDigitalService
                        ->setMesaFolio($desglose, $libroDigital, $mesa, $libro, $user);

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

                        FolioNota::create([
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
     * @param Sede $sede
     * @return JsonResponse
     * @ruta /z_test/corrige_negativos/{sedes_id}
     */
    public function corrigeNegativos(Sede $sede): JsonResponse
    {
        $inicio = microtime(true);

        $resultados = LibroDigital::where('sede_id', $sede->id)
            ->with(['mesaFolios.folioNotas.actaVolante' => function ($query) {
                $query->where('nota_escrito', -1)
                    ->orWhere('nota_oral', -1)
                    ->orWhere('promedio', -1);
            }])
            ->get();
        foreach ($resultados as $libroDigital) {
            foreach ($libroDigital->mesaFolios as $mesaFolio) {
                foreach ($mesaFolio->folioNotas as $folioNota) {
                    $actaVolante = $folioNota->actaVolante;
                    if ($actaVolante) {
                        $folioNota->update([
                            'escrito' => $this->findNumber($actaVolante->nota_escrito),
                            'oral' => $this->findNumber($actaVolante->nota_oral),
                            'definitiva' => $this->findNumber($actaVolante->promedio),
                        ]);
                    }
                }
            }
        }

        $fin = microtime(true);

        $tiempo = $fin - $inicio;

        return response()->json([
            'sede' => $sede->nombre,
            'tiempo' => $tiempo
        ]);

    }

    /**
     * @param $str
     * @return string|null
     */
    public function findNumber($str): ?string
    {
        return $this->genService->findNumber($str);
    }


}
