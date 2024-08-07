<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Proceso;
use App\Models\ProcesoCalificacion;
use App\Models\ProcesoModular;
use App\Services\CalificacionService;
use App\Services\CargoProcesoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProcesoCalificacionController extends Controller
{
    /**
     * @var CargoProcesoService
     */
    private $cargoProcesoService;
    private CalificacionService $calificacionService;

    /**
     * @param CargoProcesoService $cargoProcesoService
     * @param CalificacionService $calificacionService
     */
    public function __construct(CargoProcesoService $cargoProcesoService, CalificacionService $calificacionService)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-profesor-seccionAlumnos-coordinador-areaSocial');
        $this->cargoProcesoService = $cargoProcesoService;
        $this->calificacionService = $calificacionService;
    }

    public function show(Request $request, $id)
    {
        $proceso = Proceso::find($id);

        return response()->json($proceso->procesosCalificaciones(), 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $ausente = false;

        if (is_numeric($request['porcentaje']) || $request['porcentaje'] === 0) {
            $rules = ['required', 'numeric', 'max:100'];
        } else {
            $rules = ['required', 'string', 'regex:/^[A?a?]/'];
            $ausente = true;
        }

        $validate = Validator::make($request->all(), [
            'porcentaje' => $rules,
        ]);

        if (!$validate->fails()) {
            $calificacion = Calificacion::find($request['calificacion_id']);

            $values = [
                'porcentaje' => $ausente ? -1 : $request['porcentaje'],
                'nota' => $ausente ? -1 : $this->calcularNota((int)$request['porcentaje'], $calificacion->ciclo_lectivo),
            ];

            if ($ausente) {
                $values['porcentaje'] = -1;
                $values['nota'] = -1;
            }

            $procesoCalificacion = ProcesoCalificacion::updateOrCreate(
                [
                    'proceso_id' => $request['proceso_id'],
                    'calificacion_id' => $request['calificacion_id'],
                ],
                $values
            );

            $proceso = Proceso::find($procesoCalificacion->proceso_id);

            /** @var Calificacion $calificacion */
            $calificacion = Calificacion::find($procesoCalificacion->calificacion_id);

            if ($calificacion->tipo()->first()->descripcion == 3) {
                $procesoModular = ProcesoModular::where([
                    'proceso_id' => $proceso->id
                ])->first();
                $procesoModular->trabajo_final_porcentaje = $procesoCalificacion->porcentaje;
                $procesoModular->trabajo_final_nota = $procesoCalificacion->nota;
                $procesoModular->update();
            }
            $user = Auth::user();

            if ($procesoCalificacion->calificacion()->first()->cargo_id) {
                $this->cargoProcesoService->grabaCalificacion(
                    $procesoCalificacion->calificacion()->first()->cargo_id,
                    $calificacion->ciclo_lectivo,
                    $proceso->id,
                    $procesoCalificacion->calificacion()->first()->materia_id,
                    $user->id
                );
            }


            $response = $procesoCalificacion;
        } else {
            $response = [
                'code' => 200,
                'errors' => $validate->errors(),
            ];
        }


        return response()->json($response);
    }

    public function crearRecuperatorio(Request $request)
    {

        $ausente = false;
        if ($request['porcentaje'] && is_numeric($request['porcentaje'])) {
            $rules = ['required', 'numeric', 'max:100'];
        } elseif ($request['porcentaje'] === '0') {
            $rules = ['required', 'numeric', 'max:100'];
        } else {
            $rules = ['required', 'string', 'regex:/^[A?a?]/'];
            $ausente = true;
        }
        $validate = Validator::make($request->all(), [
            'porcentaje' => $rules,
        ]);

        if (!$validate->fails()) {
            $procesoCalificacion = ProcesoCalificacion::where([
                'proceso_id' => $request['proceso_id'],
                'calificacion_id' => $request['calificacion_id'],
            ])->first();

            $procesoCalificacion->porcentaje_recuperatorio = $request['porcentaje'];

            if (!$ausente) {
                $procesoCalificacion->nota_recuperatorio = $this->calcularNota((int)$request['porcentaje']);
            } else {
                $procesoCalificacion->nota_recuperatorio = 'A';
            }

            $procesoCalificacion->update();

            $response = $procesoCalificacion;
        } else {
            $response = [
                'code' => 200,
                'errors' => $validate->errors(),
            ];
        }

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $procesoCalificacion = ProcesoCalificacion::where([
            'proceso_id' => $request['proceso_id'],
            'calificacion_id' => $request['calificacion_id'],
        ])->first();

        if ($procesoCalificacion) {
            if ($request['recuperatorio']) {
                $procesoCalificacion->porcentaje_recuperatorio = null;
                $procesoCalificacion->nota_recuperatorio = null;
                $response = 'recuperatorio_eliminado';
            } else {
                $procesoCalificacion->porcentaje = null;
                $procesoCalificacion->nota = null;
                $response = 'calificacion_eliminada';
            }

            $procesoCalificacion->update();
        }

        return response($response, 200);
    }

    private function calcularNota($porcentaje, $year =  null)
    {

        //        if ($porcentaje == 0) {
        //            $nota = 0;
        //        } else {
        //            if ($porcentaje >= 1 && $porcentaje <= 19) {
        //                $nota = 1;
        //            } else {
        //                if ($porcentaje >= 20 && $porcentaje <= 39) {
        //                    $nota = 2;
        //                } else {
        //                    if ($porcentaje >= 40 && $porcentaje <= 59) {
        //                        $nota = 3;
        //                    } else {
        //                        if ($porcentaje >= 60 && $porcentaje <= 65) {
        //                            $nota = 4;
        //                        } else {
        //                            if ($porcentaje >= 66 && $porcentaje <= 71) {
        //                                $nota = 5;
        //                            } else {
        //                                if ($porcentaje >= 72 && $porcentaje <= 77) {
        //                                    $nota = 6;
        //                                } else {
        //                                    if ($porcentaje >= 78 && $porcentaje <= 83) {
        //                                        $nota = 7;
        //                                    } else {
        //                                        if ($porcentaje >= 84 && $porcentaje <= 89) {
        //                                            $nota = 8;
        //                                        } else {
        //                                            if ($porcentaje >= 90 && $porcentaje <= 95) {
        //                                                $nota = 9;
        //                                            } else {
        //                                                if ($porcentaje >= 96 && $porcentaje <= 100) {
        //                                                    $nota = 10;
        //                                                }
        //                                            }
        //                                        }
        //                                    }
        //                                }
        //                            }
        //                        }
        //                    }
        //                }
        //            }
        //        }
        $nota = $this->calificacionService->getNotaByPorcentaje($porcentaje, $year);
        return $nota;
    }

    public function calcularPorcentaje(Request $request)
    {

        $proceso = Proceso::find($request['proceso_id']);


        $calificaciones = ProcesoCalificacion::where([
            'proceso_id' => $proceso->id,
        ])->whereHas('calificacion', function ($query) {
            return $query->where('tipo_id', 2);
        })->get();

        if (count($calificaciones) > 0) {
            $array_calificaciones = [];
            $array_promedios = [];

            foreach ($calificaciones as $calificacion) {
                if ($calificacion->nota == -1) {
                    array_push($array_calificaciones, 0);
                    array_push($array_promedios, 0);
                } else {
                    array_push($array_calificaciones, $calificacion->nota);
                    array_push($array_promedios, $calificacion->porcentaje);
                }
            }

            $valorInicial = 0;
            $valorInicial2 = 0;
            $suma = array_reduce($array_calificaciones, function ($acarreo, $numero) {
                return $acarreo + $numero;
            }, $valorInicial);

            $suma_porcentajes = array_reduce($array_promedios, function ($acarreo, $numero) {
                return $acarreo + $numero;
            }, $valorInicial2);

            // Obtener longitud
            $cantidadPromedio = count($array_calificaciones);
            $cantidadPorcentaje = count($array_promedios);

            // Dividir, y listo
            $promedio = $suma / $cantidadPromedio;
            $promedio_porcentaje = $suma_porcentajes / $cantidadPorcentaje;

            $proceso->final_asistencia = optional($proceso->asistencia())->porcentaje_final;
            $proceso->porcentaje_final_trabajos = round($promedio_porcentaje, 0, PHP_ROUND_HALF_UP);
            $proceso->final_trabajos = $this->calcularNota($proceso->porcentaje_final_trabajos);
            $proceso->update();
        }


        return response()->json($proceso, 200);
    }
}
