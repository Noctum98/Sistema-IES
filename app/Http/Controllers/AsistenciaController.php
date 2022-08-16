<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Asistencia;
use App\Models\AsistenciaModular;
use App\Models\Cargo;
use App\Models\Comision;
use App\Models\Proceso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AsistenciaController extends Controller
{
    function __construct()
    {
        // $this->middleware('app.admin');
        // $this->middleware('app.roles:admin-profesor');
    }

    // Vistas
    public function vista_carreras()
    {
        $materias = Auth::user()->materias;
        $cargos = Auth::user()->cargos;

        $ruta = 'asis.admin';

        return view('asistencia.home', [
            'materias' => $materias,
            'ruta' => $ruta,
            'cargos' => $cargos,
        ]);
    }

    /**
     * @param Request $request
     * @param int $id <b>id</b> de la materia.
     * @param $cargo_id <b>id</> del cargo.
     * @return Application|Factory|View
     */
    public function vista_admin(Request $request, int $id, $cargo_id = null)
    {

        $comision_id = $request['comision_id'] ? $request['comision_id'] : null;
        $materia = Materia::find($id);
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia->id);

        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }

        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();

        $datos = [
            'materia' => $materia,
            'procesos' => $procesos,
        ];

        if ($cargo_id) {
            $cargo = Cargo::find($cargo_id);
            $datos['cargo'] = $cargo;
        }

        if ($comision_id) {
            $datos['comision'] = Comision::find($comision_id);
        }

        return view('asistencia.admin', $datos);
    }

    public function vista_fecha(int $id)
    {
        $materia = Materia::find($id);

        return view('asistencia.date', [
            'materia' => $materia,
        ]);
    }

    public function vista_crear(int $id)
    {
        $asistencia = Asistencia::find($id);
        $procesos = Proceso::where('materia_id', $asistencia->materia_id)->get();

        return view('asistencia.create', [
            'procesos' => $procesos,
            'asistencia' => $asistencia,
        ]);
    }

    public function vista_cerrar(int $id)
    {
        $procesos = Proceso::where('materia_id', $id)->get();
        $asistencias = Asistencia::where('materia_id', $id)->get();

        return view('asistencia.close', [
            'procesos' => $procesos,
            'asistencias' => $asistencias,
        ]);
    }

    // Funcionalidades

    public function crear(Request $request)
    {
        $validate = $this->validate($request, [
            'porcentaje_final' => ['required', 'numeric'],
        ]);

        $issetAsistencia = Asistencia::where('proceso_id', $request['proceso_id'])->first();

        if ($issetAsistencia) {
            $issetAsistencia->porcentaje_final = $request['porcentaje_final'];
            $issetAsistencia->update();
            $asistencia = $issetAsistencia;
        } else {
            $asistencia = Asistencia::create($request->all());
        }

        return response()->json([
            'message' => 'Asistencia creada con éxito!',
            'asistencia' => $asistencia,
        ], 200);
    }

    public function crear_7030(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'porcentaje_virtual' => ['required', 'numeric'],
            'porcentaje_presencial' => ['required', 'numeric','max:30'],
        ]);

        $porcentaje_final = $request['porcentaje_virtual'] + $request['porcentaje_presencial'];

        if($porcentaje_final > 100)
        {
            $response = [
                'message' => 'Error',
                'errors' =>[
                    "porcentaje_presencial" => [
                      0 => "La suma de las asistencias no debe ser mayor a 100"
                    ]
                ]
            ];
            return response()->json($response, 200);
        }

        if (!$validate->fails()) {
            $issetAsistencia = Asistencia::where('proceso_id', $request['proceso_id'])->first();

            $request['porcentaje_final'] = (int)$request['porcentaje_virtual'] + $request['porcentaje_presencial'];

            if ($issetAsistencia) {
                $issetAsistencia->update($request->all());
                $asistencia = $issetAsistencia;
            } else {
                $asistencia = Asistencia::create($request->all());
            }

            $response = [
                'message' => 'Asistencia creada con éxito!',
                'asistencia' => $asistencia,
            ];
        } else {
            $response = [
                'message' => 'Error',
                'errors' => $validate->errors(),
            ];
        }

        return response()->json($response, 200);
    }

    public function crear_modular(Request $request)
    {
        $validate = $this->validate($request, [
            'porcentaje' => ['required', 'numeric'],
        ]);

        $asistencia = Asistencia::where([
            'proceso_id' => $request['proceso_id'],
        ])->first();

        if ($asistencia) {
            $asistencia_modular = AsistenciaModular::getByAsistenciaCargo($request['cargo_id'], $asistencia->id);
            if ($asistencia_modular) {
                $asistencia_modular->porcentaje = (int)$request['porcentaje'];
                $asistencia_modular->update();
            } else {
                $request['asistencia_id'] = $asistencia->id;
                $asistencia_modular = AsistenciaModular::create($request->all());
            }
        } else {
            $asistencia = Asistencia::create($request->all());

            $request['asistencia_id'] = $asistencia->id;
            $asistencia_modular = AsistenciaModular::create($request->all());
        }

        $response = [
            'message' => 'Asistencia creada con éxito!',
            'asistencia' => $asistencia,
        ];

        return response()->json($response, 200);
    }

    public function crear_modular_7030(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'porcentaje_virtual' => ['required', 'numeric'],
            'porcentaje_presencial' => ['required', 'numeric'],
        ]);

        $porcentaje_final = $request['porcentaje_virtual'] + $request['porcentaje_presencial'];

        if($porcentaje_final > 100)
        {
            $response = [
                'message' => 'Error',
                'errors' =>[
                    "porcentaje_presencial" => [
                      0 => "La suma de las asistencias no debe ser mayor a 100"
                    ]
                ]
            ];
            return response()->json($response, 200);
        }

        if (!$validate->fails()) {
            $asistencia = Asistencia::where([
                'proceso_id' => $request['proceso_id'],
            ])->first();

            if ($asistencia) {
                $asistencia_modular = AsistenciaModular::getByAsistenciaCargo($request['cargo_id'], $asistencia->id);
                if ($asistencia_modular) {
                    $asistencia_modular->porcentaje_virtual = (int)$request['porcentaje_virtual'];
                    $asistencia_modular->porcentaje_presencial = (int)$request['porcentaje_presencial'];
                    $asistencia_modular->porcentaje = $asistencia_modular->porcentaje_virtual + $asistencia_modular->porcentaje_presencial;
                    $asistencia_modular->update();
                } else {
                    $request['asistencia_id'] = $asistencia->id;
                    $request['porcentaje'] = (int)$request['porcentaje_virtual'] + (int)$request['porcentaje_presencial'];
                    $asistencia_modular = AsistenciaModular::create($request->all());
                }
            } else {
                $asistencia = Asistencia::create([
                    'proceso_id' => $request['proceso_id'],
                ]);

                $request['asistencia_id'] = $asistencia->id;
                $request['porcentaje'] = (int)$request['porcentaje_virtual'] + (int)$request['porcentaje_presencial'];
                $asistencia_modular = AsistenciaModular::create($request->all());
            }

            $response = [
                'message' => 'Asistencia creada con éxito!',
                'code' => 200,
                'asistencia' => $asistencia_modular,
            ];
        } else {
            $response = [
                'message' => 'Error',
                'code' => 200,
                'errors' => $validate->errors(),
            ];
        }


        return response()->json($response, $response['code']);
    }
}
