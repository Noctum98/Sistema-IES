<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Calificaciones;
use App\Models\Comision;
use App\Models\ComisionMateria;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesoCalificacion;
use App\Models\TipoCalificacion;
use App\Models\TipoCalificaciones;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador-profesor-regente');
    }

    public function home()
    {
        $user = Auth::user();
        // dd($user_id);
        $materias = $user->materias;
        $cargos = $user->cargos;
        $ruta = 'calificacion.admin';

        // dd($materias,$cargos);

        return view('calificacion.home', [
            'materias' => $materias,
            'cargos' => $cargos,
            'ruta' => $ruta
        ]);
    }

    public function admin($materia_id, $cargo_id = null)
    {
        $materia = Materia::find($materia_id);

        if ($materia->carrera->tipo == 'modular' || $materia->carrera->tipo == 'modular2') {
            $tiposCalificaciones = TipoCalificacion::all();
        } else {
            $tiposCalificaciones = TipoCalificacion::where('descripcion', '!=', 3)->get();
        }

        $user = Auth::user();

        if ($user->hasAnyRole(['coordinador', 'admin', 'regente'])) {
            $calificaciones = Calificacion::where('materia_id', $materia->id)->get();
        } else {

            if ($materia->carrera->tipo == 'modular' || $materia->carrera->tipo == 'modular2' && $cargo_id) {
                $calificaciones = Calificacion::where([
                    'materia_id' => $materia->id,
                    'cargo_id' => $cargo_id
                ]);
            } else {
                $calificaciones = Calificacion::where([
                    'materia_id' => $materia->id,
                ]);
            }

            $calificaciones = $calificaciones->orWhereHas('tipo', function ($query) use ($materia) {
                $query->where([
                    'materia_id' => $materia->id,
                    'descripcion'=> 3
                ]);
            })->orderBy('comision_id')->get();
        }

        return view('calificacion.admin', [
            'materia' => $materia,
            'tiposCalificaciones' =>  $tiposCalificaciones,
            'calificaciones' => $calificaciones,
            'cargo_id' => $cargo_id
        ]);
    }

    public function create($calificacion_id)
    {
        $calificacion = Calificacion::find($calificacion_id);
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $calificacion->materia_id);

            
        if ($calificacion->comision_id) {
            $procesos->where('alumnos.comision_id', $calificacion->comision_id);
        }

        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();

        if ($calificacion) {
            return view('calificacion.create', [
                'calificacion' => $calificacion,
                'procesos' => $procesos
            ]);
        }
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'nombre' =>  ['required'],
            'tipo_id' => ['required'],
            'fecha' => ['required']
        ]);

        if($request['comision_id'] && !Auth::user()->hasComision($request['comision_id'])){
            $mensaje = ['error_comision'=>'No tienes permiso para trabajar en esta comisión'];

            return redirect()->route('calificacion.admin', [
                'materia_id' => $request['materia_id'],
                'cargo_id' => $request['cargo_id']
            ])->with($mensaje);
        }

        $calificacionFinal = $this->verificarFinalIntegrador($request);

        if ($calificacionFinal) {
            $mensaje = ['calificacion_fallo' => 'Ya existe un trabajo integrador final en esta materia'];
        } else {
            $calificacion = Calificacion::create($request->all());
            $mensaje = ['calificacion_creada' => 'Calificación creada!'];
        }

        return redirect()->route('calificacion.admin', [
            'materia_id' => $request['materia_id'],
            'cargo_id' => $request['cargo_id']
        ])->with($mensaje);
    }

    public function delete(Request $request, $id)
    {
        $calificacion = Calificacion::find($id);

        ProcesoCalificacion::where('calificacion_id', $calificacion->id)->delete();

        $calificacion->delete();

        return redirect()->route('calificacion.admin', [
            'materia_id' => $calificacion->materia_id
        ])->with('calificacion_eliminada', 'La calificación ha sido eliminada');
    }

    private function verificarFinalIntegrador(Request $request)
    {
        $calificacionFinal = Calificacion::select('calificaciones.*')
            ->join('tipo_calificaciones', 'tipo_calificaciones.id', 'calificaciones.tipo_id')
            ->where('calificaciones.materia_id', $request['materia_id'])
            ->where('tipo_calificaciones.descripcion', 3)
            ->first();

        if ($calificacionFinal) {
            return $calificacionFinal;
        } else {
            return false;
        }
    }
}
