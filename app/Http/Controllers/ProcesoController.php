<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Cargo;
use App\Models\CargoProceso;
use App\Models\Comision;
use App\Models\Estados;
use App\Models\Materia;
use App\Models\Proceso;

use App\Services\CargoProcesoService;
use App\Services\CicloLectivoService;
use App\Services\ProcesosCargosService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProcesoController extends Controller
{
    /**
     * @var CicloLectivoService
     */
    private $cicloLectivoService;
    private CargoProcesoService $cargoProcesoService;

    /**
     * @param CicloLectivoService $cicloLectivoService
     * @param CargoProcesoService $cargoProcesoService
     */
    function __construct(CicloLectivoService $cicloLectivoService, CargoProcesoService $cargoProcesoService)
    {
        $this->middleware('app.auth', ['except' => 'delete']);
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente-profesor-areaSocial',
            ['except' => 'delete']);
        $this->cicloLectivoService = $cicloLectivoService;
        $this->cargoProcesoService = $cargoProcesoService;
    }

    // Vistas
    public function vista_inscribir($id)
    {
        $alumno = Alumno::find($id);
        $materias = Materia::where('carrera_id', $alumno->carrera_id)->get();
        $procesos = Proceso::orderBy('estado')->where('alumno_id', $alumno->id)->get();
        $mis_materias = [];
        $mis_materias = $materias->toArray();

        for ($contador = 0; $contador < count($mis_materias); $contador++) {
            foreach ($procesos as $proceso) {
                if ($proceso->materia_id == $mis_materias[$contador]['id']) {
                    unset($mis_materias[$contador]);
                    $mis_materias = array_values($mis_materias);
                }
            }
        }

        return view('alumno.enroll', [
            'alumno' => $alumno,
            'materias' => $mis_materias,
            'procesos' => $procesos,
        ]);
    }

    public function vista_detalle(int $id)
    {
        $proceso = Proceso::find($id);

        return view('proceso.detail', [
            'proceso' => $proceso,
        ]);
    }

    public function vista_listado($materia_id, $ciclo_lectivo, $comision_id = null)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('procesos.ciclo_lectivo', $ciclo_lectivo);

        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }
        $materia = Materia::find($materia_id);
        $comision = null;
        if ($comision_id) {
            $comision = Comision::find($comision_id);
        }
        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();

        $calificacion = Calificacion::where([
            'materia_id' => $materia_id,
            'tipo_id' => 1,
            'ciclo_lectivo' => $ciclo_lectivo
        ]);
        if ($comision_id) {
            $calificacion->where([
                'comision_id' => $comision_id,
            ]);
        }
        $calificaciones = $calificacion->orderBy('tipo_id', 'DESC')->get();

        $estados = Estados::all();

        return view('proceso.listado', [
            'procesos' => $procesos,
            'materia' => $materia,
            'comision' => $comision,
            'calificaciones' => $calificaciones,
            'estados' => $estados,
            'ciclo_lectivo' => $ciclo_lectivo
        ]);
    }

    public function vista_listadoCargo($materia_id, $cargo_id, $ciclo_lectivo = null, $comision_id = null)
    {
        $user = Auth::user();
        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        $procesos = $this->getProcesosMateria($materia_id, $ciclo_lectivo, $comision_id);

        $comision = null;
        if ($comision_id) {
            $comision = Comision::find($comision_id);
        }
        $materia = Materia::find($materia_id);

        $calificacion = Calificacion::where([
            'materia_id' => $materia_id,
            'cargo_id' => $cargo_id,
            'ciclo_lectivo' => $ciclo_lectivo
        ]);
        if ($comision_id) {
            $calificacion->where([
                'comision_id' => $comision_id,
            ]);
        }
        $calificaciones = $calificacion->orderBy('tipo_id', 'DESC')->get();
        $estados = Estados::all();
        $cargo = Cargo::find($cargo_id);

        $cargosProcesos = new CargoProceso();

        $cantCargosProcesos = count($cargosProcesos->getCargosProcesosByProcesos(
            $cargo_id, $procesos->pluck('id')->toArray()));

//        $vincular = false;
        if ($cantCargosProcesos < count($procesos)) {

            $this->cargoProcesoService->allStore(
                $materia_id, $cargo_id, $ciclo_lectivo, $user->id, $comision_id);

//            $vincular = true;
        }


        return view('proceso.listado-modular', [
            'procesos' => $procesos,
            'materia' => $materia,
            'comision' => $comision,
            'calificaciones' => $calificaciones,
            'estados' => $estados,
            'cargo' => $cargo,
            'ciclo_lectivo' => $ciclo_lectivo,
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
//            'vincular' => $vincular
        ]);
    }

    public function vista_listadoModular($materia_id, $comision_id = null)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id);

        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }
        $materia = Materia::find($materia_id);
        $comision = null;
        if ($comision_id) {
            $comision = Comision::find($comision_id);
        }
        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();
        $calificacion = Calificacion::where([
            'materia_id' => $materia_id,
        ]);
        if ($comision_id) {
            $calificacion->where([
                'comision_id' => $comision_id,
            ]);
        }
        $calificaciones = $calificacion->orderBy('tipo_id', 'DESC')->get();
        $estados = Estados::all();

        return view('proceso.listado', [
            'procesos' => $procesos,
            'materia' => $materia,
            'comision' => $comision,
            'calificaciones' => $calificaciones,
            'estados' => $estados,
        ]);
    }

    public function vista_listadoCargosModulo($materia_id, $cargo_id, $alumno_id, $comision_id = null)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('procesos.alumno_id', $alumno_id)//            ->where('procesos.cargo_id', $cargo_id);
        ;
        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }
        $materia = Materia::find($materia_id);
        $cargo = Cargo::find($cargo_id);
        $comision = null;
        if ($comision_id) {
            $comision = Comision::find($comision_id);
        }
        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();
        $calificacion = Calificacion::where([
            'materia_id' => $materia_id,
        ]);
        if ($comision_id) {
            $calificacion->where([
                'comision_id' => $comision_id,
            ]);
        }
        $calificaciones = $calificacion->orderBy('tipo_id', 'DESC')->get();
        $estados = Estados::all();

        $alumno = Alumno::find($alumno_id);

        $cargos = $procesos->first()->materia->cargos;

        return view('proceso.listado-cargos-modulo', [
            'procesos' => $procesos,
            'materia' => $materia,
            'comision' => $comision,
            'calificaciones' => $calificaciones,
            'estados' => $estados,
            'cargo' => $cargo,
            'alumno' => $alumno,
            'cargos' => $cargos,
        ]);
    }

    public function administrar(Request $request, $id)
    {
        $alumno = Alumno::find($id);
        $procesos = $request['materias'];
        $alumno_procesos = $alumno->procesos->where('ciclo_lectivo', date('Y'));

        foreach ($alumno_procesos as $proceso) {

            if (!$procesos || !in_array($proceso->materia_id, $procesos)) {
                $proceso->delete();
            }
        }

        if ($procesos) {
            // Si el rol que viene en el form ya lo tiene no lo crea y pasa al siguiente
            foreach ($procesos as $key => $proceso) {
                if ($alumno->hasProceso($proceso)) {
                    $proceso = null;
                }
                if ($proceso) {

                    $proceso_deleted = Proceso::withTrashed()
                        ->where([
                            'alumno_id' => $alumno->id,
                            'materia_id' => $proceso,
                            'ciclo_lectivo' => date('Y')
                        ])
                        ->latest('deleted_at')
                        ->first();

                    if ($proceso_deleted) {
                        $proceso_deleted->restore();
                    } else {
                        Proceso::create([
                            'alumno_id' => $alumno->id,
                            'estado' => 'en curso',
                            'materia_id' => $proceso,
                            'ciclo_lectivo' => date('Y')
                        ]);
                    }
                }
            }
        }


        return redirect()->route('alumno.detalle', [
            'id' => $alumno->id,
        ])->with([
            'mensaje_procesos' => 'Se han actualizado los procesos',
        ]);
    }

    public function delete(Request $request, $id, $alumno_id)
    {
        $alumno = Alumno::select('id')->where('id', $alumno_id)->first();

        $proceso = Proceso::where([
            'id' => $id,
            'alumno_id' => $alumno_id
        ])->first();

        if ($proceso) {
            $proceso->delete();

            $data = [
                'status' => 'success',
                'message' => 'Proceso eliminado'
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Error'
            ];
        }

        return response()->json($data, 200);
    }

    public function cambiaEstado(Request $request): JsonResponse
    {
        $user = Auth::user();

        $estado = Estados::find($request['estado_id']);
        $proceso = Proceso::find($request['proceso_id']);
        $proceso->estado_id = $estado->id;
        $proceso->operador_id = $user->id;

        $proceso->update();

        $data = [
            'message' => '¡Proceso actualizado!',
            'estado' => $proceso->estado,
        ];

        return response()->json($data, 200);
    }

    /**
     * Cerramos el proceso completo
     * @param Request $request
     * @return JsonResponse
     */
    public function cambiaCierre(Request $request): JsonResponse
    {
        $user = Auth::user();

        $proceso = Proceso::find($request['proceso_id']);
        $cierre_modulo = true;
        if (isset($request['cargo'])) {
            $cierre_modulo = false;
        }

        if ($cierre_modulo) {
            $proceso = $this->cierreToTrue($request['cierre'], $proceso);

            $proceso->operador_id = $user->id;

            $proceso->update();
        }

        if ($proceso->cierre == 1 && $proceso->materia()->first() && $proceso->materia()->first()->cargos()->get()) {
            foreach ($proceso->materia()->first()->cargos()->get() as $cargo) {
                $procesoService = new ProcesosCargosService();
                $procesoService->actualizar($proceso->id, $cargo->id, $user->id, $cierre_modulo);
            }
        }


        return response()->json($proceso, 200);
    }

    public function cambiaCierreModulo(Request $request): JsonResponse
    {
        $user = Auth::user();
        $proceso = Proceso::find($request['proceso_id']);


        $proceso = $this->cierreToTrue($request['cierre'], $proceso);

        $proceso->operador_id = $user->id;

        $proceso->update();

        //

        if ($proceso->materia()->first() && $proceso->materia()->first()->cargos()->get()) {
            foreach ($proceso->materia()->first()->cargos()->get() as $cargo) {
                $procesoService = new ProcesosCargosService();
                $procesoService->actualizar($proceso->id, $cargo->id, $user->id);
            }
        }


        if ($request['tipo'] && $request['tipo'] == 'modular' && $request['cargo']) {
            $cargo_id = $request['cargo'];
            $procesoService = new ProcesosCargosService();
            $procesoService->actualizar($proceso->id, $cargo_id, $user->id);
        } else {
            $proceso->operador_id = $user->id;
            $proceso->update();

            if ($proceso->materia()->first() && $proceso->materia()->first()->cargos()->get()) {
                foreach ($proceso->materia()->first()->cargos()->get() as $cargo) {
                    $procesoService = new ProcesosCargosService();
                    $procesoService->actualizar($proceso->id, $cargo->id, $user->id);
                }
            }
        }


        return response()->json($proceso, 200);
    }

    /**
     * @param $materia_id
     * @param null $cargo_id
     * @param null $comision_id
     * @param bool $cierre_coordinador
     * @return Application|RedirectResponse|Redirector
     */
    public function cambiaCierreGeneral(
        $materia_id,
        $cargo_id = null,
        $comision_id = null,
        bool $cierre_coordinador = false
    )
    {

        $user = Auth::user();
        if ($comision_id == 0) {
            $comision_id = null;
        }
        $procesos = $this->getProcesosMateria($materia_id, $comision_id);
        if ($cargo_id && !$cierre_coordinador) {
            $procesoService = new ProcesosCargosService();
            foreach ($procesos as $proceso) {
                $procesoService->cierraProcesoCargo($cargo_id, $proceso->id, $user->id, true);
            }
        } else {
            foreach ($procesos as $proceso) {
                $proceso->cierre = 1;
                $proceso->operador_id = $user->id;
                $proceso->update();

                if ($proceso->materia()->first() && $proceso->materia()->first()->cargos()->get()) {
                    foreach ($proceso->materia()->first()->cargos()->get() as $cargo) {
                        $procesoService = new ProcesosCargosService();
                        $procesoService->cierraProcesoCargo($cargo->id, $proceso->id, $user->id, true);
                    }
                }

            }
        }

        $data = '/' . $materia_id;
        if ($cargo_id) {
            $data .= '/' . $cargo_id;
        }
        if ($comision_id) {
            $data .= '/' . $comision_id;
        }

        if ($cierre_coordinador) {
            return redirect("proceso-modular/listado" . $data)->with('status', 'Procesos Cerrados');
        }

        return redirect("proceso/listado-cargo" . $data)->with('status', 'Procesos Cerrados');
    }


    public function cambia_nota_final(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'proceso_id' => ['required', 'integer'],
            'nota_final' => ['required', 'integer', 'max:10'],
        ]);

        if (!$validate->fails()) {
            $proceso = Proceso::find($request['proceso_id']);
            $proceso->final_calificaciones = $request['nota_final'];
            $proceso->update();

            $response = [
                'code' => 200,
                'nota' => $proceso->final_calificaciones,
            ];

        } else {
            $response = [
                'code' => 200,
                'errors' => $validate->errors(),
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function cambia_nota_global(Request $request): JsonResponse
    {
        $ausente = false;
        if (is_numeric($request['nota_global']) || $request['nota_global'] === 0) {
            $rules = ['required', 'numeric', 'max:10'];
        } else {
            $rules = ['required', 'string', 'regex:/^[A?a?]/'];
            $ausente = true;
        }

        $validate = Validator::make($request->all(), [
            'proceso_id' => ['required', 'integer'],
            'nota_global' => $rules,
        ]);
        $nota_global = $request['nota_global'];
        if ($ausente) {
            $nota_global = -1;
        }

        if (!$validate->fails()) {
            $proceso = Proceso::find($request['proceso_id']);
            $proceso->nota_global = $nota_global;

            if ($nota_global >= 4) {
                $estado = Estados::where(
                    ['identificador' => 7]
                )->first();
            } else {
                $estado = Estados::where(
                    ['identificador' => 5]
                )->first();
            }
            $proceso->estado_id = $estado->id;

            $proceso->update();

            $response = [
                'code' => 200,
                'nota' => $proceso->nota_global,
                'estado' => $proceso->estado_id
            ];

        } else {
            $response = [
                'code' => 200,
                'errors' => $validate->errors(),
            ];
        }

        return response()->json($response, $response['code']);
    }

    /**
     * @param $materia_id <integer> <i>id</i> de la materia.
     * @param $ciclo_lectivo <integer> <i>ciclo lectivo</i>
     * @param null $comision_id <integer | null> <i>id</i> de la comisión, puede ser null.
     * @return Collection
     */
    protected function getProcesosMateria($materia_id, $ciclo_lectivo, $comision_id = null): Collection
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('procesos.ciclo_lectivo', $ciclo_lectivo);

        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }

        $procesos->orderBy('alumnos.apellidos', 'asc');

        return $procesos->get();
    }

    /**
     * @param $cierre
     * @param Proceso $proceso
     * @return Proceso
     */
    protected function cierreToTrue($cierre, Proceso $proceso): Proceso
    {
        $proceso->cierre = 0;
        if ($cierre == 'true') {
            $proceso->cierre = 1;
        }
        return $proceso;
    }
}
