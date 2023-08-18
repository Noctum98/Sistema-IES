<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Cargo;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesoCalificacion;
use App\Models\TipoCalificacion;
use App\Models\User;
use App\Services\CicloLectivoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    const CICLO_LECTIVO_INICIAL = 2022;
    /**
     * @var CicloLectivoService
     */
    private $cicloLectivoService;

    /**
     * @param CicloLectivoService $cicloLectivoService
     */
    public function __construct(CicloLectivoService $cicloLectivoService)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador-profesor-regente-seccionAlumnos-areaSocial');
        $this->cicloLectivoService = $cicloLectivoService;
    }

    public function home($ciclo_lectivo = null)
    {
        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        $user = User::find(Auth::user()->id);
        // dd($user_id);
        $materias = $user->materias;
        $cargos = $user->cargos;
        $ruta = 'calificacion.admin';

        $cargos_materia = [];
        if (count($user->cargo_materia()->get()) > 0) {
            foreach ($user->cargo_materia()->get() as $cargo_materia) {
                $cargos_materia[] = $cargo_materia->cargo->id;
            }
        }
        $cargos = $user->cargos->whereNotIn('id', $cargos_materia);

        return view('calificacion.home', [
            'materias' => $materias,
            'cargos' => $cargos,
            'ruta' => $ruta,
            'ciclo_lectivo' => $ciclo_lectivo,
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
        ]);
    }

    public function admin($materia_id, $ciclo_lectivo, $cargo_id = null)
    {
        $materia = Materia::find($materia_id);


        $user = Auth::user();
        $calificaciones = Calificacion::select()
            ->where('materia_id', $materia->id)
            ->where('ciclo_lectivo', $ciclo_lectivo);
        if ($cargo_id) {
            $cargo = Cargo::select('nombre', 'id')->where('id', $cargo_id)->first();
            if ($cargo) {
                $calificaciones->where('cargo_id', $cargo_id);
            }
        }

        if ($materia->carrera->tipo == 'modular' || $materia->carrera->tipo == 'modular2') {
            /** @var Cargo $cargo */
            if ($cargo->responsableTFI($materia->id) === 1) {
                $tiposCalificaciones = TipoCalificacion::all();
            } else {
                $tiposCalificaciones = TipoCalificacion::where('descripcion', '!=', 3)->get();
            }

        } else {
            $tiposCalificaciones = TipoCalificacion::where('descripcion', '!=', 3)->get();
        }

        $calificaciones = $calificaciones->orderBy('tipo_id')->get();

        return view('calificacion.admin', [
            'materia' => $materia,
            'tiposCalificaciones' => $tiposCalificaciones,
            'calificaciones' => $calificaciones,
            'cargo' => $cargo ?? null,
            'ciclo_lectivo' => $ciclo_lectivo,
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
        ]);
    }

    public function create($calificacion_id)
    {
        $calificacion = Calificacion::find($calificacion_id);
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $calificacion->materia_id)
            ->where('procesos.ciclo_lectivo', $calificacion->ciclo_lectivo);


        if ($calificacion->comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($calificacion) {
                $query->whereHas('comisiones', function ($query) use ($calificacion) {
                    $query->where('comisiones.id', $calificacion->comision_id);
                });
            });
        }

        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();

        if ($calificacion) {
            return view('calificacion.create', [
                'calificacion' => $calificacion,
                'procesos' => $procesos,
            ]);
        }
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'nombre' => ['required'],
            'tipo_id' => ['required'],
            'fecha' => ['required'],
        ]);

        $ciclo_lectivo = substr($request['fecha'], 0, 4,);

        if ($request['comision_id'] && !Auth::user()->hasComision($request['comision_id'])) {
            $mensaje = ['error_comision' => 'No tienes permiso para trabajar en esta comisión'];

            return redirect()->route('calificacion.admin', [
                'materia_id' => $request['materia_id'],
                'cargo_id' => $request['cargo_id'],
            ])->with($mensaje);
        }

        $calificacionFinal = $this->verificarFinalIntegrador($request);
        $request['description'] = trim($request['description']);

        if ($calificacionFinal) {
            $mensaje = ['calificacion_fallo' => 'Ya existe un trabajo integrador final en esta materia'];
        } else {
            $calificacion = Calificacion::create($request->all());
            $calificacion->ciclo_lectivo = $ciclo_lectivo;
            $calificacion->update();
            $mensaje = ['calificacion_creada' => 'Calificación creada!'];
        }

        return redirect()->route('calificacion.admin', [
            'materia_id' => $request['materia_id'],
            'ciclo_lectivo' => $ciclo_lectivo,
            'cargo_id' => $request['cargo_id'],
        ])->with($mensaje);
    }

    public function edit(Calificacion $calificacion)
    {

        if ($calificacion->materia->carrera->tipo == 'modular' || $calificacion->materia->carrera->tipo == 'modular2') {
            $tiposCalificaciones = TipoCalificacion::all();
        } else {
            $tiposCalificaciones = TipoCalificacion::where('descripcion', '!=', 3)->get();
        }

        return view('calificacion.modals.form_edit_calificacion')->with([
            'calificacion' => $calificacion,
            'tiposCalificaciones' => $tiposCalificaciones,
        ]);
    }

    public function update(Request $request, Calificacion $calificacion)
    {
        $validate = $this->validate($request, [
            'nombre' => ['required'],
            'tipo_id' => ['required'],
            'fecha' => ['required'],
        ]);
        $ciclo_lectivo = substr($request['fecha'], 0, 4,);

        if ($calificacion->comision_id && !Auth::user()->hasComision($calificacion->comision_id)) {
            $mensaje = ['error_comision' => 'No tienes permiso para trabajar en esta comisión'];

            return redirect()->route('calificacion.admin', [
                'materia_id' => $calificacion->materia_id,
                'cargo_id' => $calificacion->cargo_id,
                'ciclo_lectivo' => $ciclo_lectivo,
            ])->with($mensaje);
        }
        $request['description'] = trim($request['description']);
        $calificacion->update($request->all());
        $mensaje = ['calificacion_creada' => '¡Calificación actualizada!'];

        return redirect()->route('calificacion.admin', [
            'materia_id' => $request['materia_id'],
            'cargo_id' => $request['cargo_id'],
            'ciclo_lectivo' => $ciclo_lectivo,
        ])->with($mensaje);
    }

    public function delete(Request $request, $id)
    {
        $calificacion = Calificacion::find($id);

        ProcesoCalificacion::where('calificacion_id', $calificacion->id)->delete();
        $calificacion->delete();

        return redirect()->back();
//        route('calificacion.admin', [
//            'materia_id' => $calificacion->materia_id,
//        ])->with('calificacion_eliminada', 'La calificación ha sido eliminada');
    }

    /**
     * Busca si el módulo o materia ya tienen un TFI cargado
     * @param Request $request
     * @return bool
     */
    private function verificarFinalIntegrador(Request $request): bool
    {
        $tipoCalificacion = TipoCalificacion::select('tipo_calificaciones.*')
            ->where('tipo_calificaciones.id', $request['tipo_id'])
            ->first();
        if ($tipoCalificacion->descripcion == 3) {
            $calificacionFinal = Calificacion::select('calificaciones.*')
                ->join('tipo_calificaciones', 'tipo_calificaciones.id', 'calificaciones.tipo_id')
                ->where('calificaciones.materia_id', $request['materia_id'])
                ->where('tipo_calificaciones.descripcion', 3)
                ->where('calificaciones.ciclo_lectivo', $request['ciclo_lectivo'])
                ->first();

            if ($calificacionFinal) {
                return true;
            }
        }

        return false;

    }
}
