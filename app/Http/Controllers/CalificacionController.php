<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Calificaciones;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\TipoCalificacion;
use App\Models\TipoCalificaciones;
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

        return view('calificacion.home',[
            'materias' => $materias,
            'cargos' => $cargos,
            'ruta' => $ruta
        ]);
    }

    public function admin($materia_id)
    {
        $materia = Materia::find($materia_id);

        if($materia->carrera->tipo == 'modular' || $materia->carrera->tipo == 'modular2')
        {
            $tiposCalificaciones = TipoCalificacion::all();
        }else{
            $tiposCalificaciones = TipoCalificacion::where('descripcion','!=',3)->get();
        }

        $user = Auth::user();
        
        if($user->hasAnyRole(['coordinador','admin','regente'])){
            $calificaciones = Calificacion::where('materia_id',$materia->id)->get();
        }else{
            $calificaciones = Calificacion::where([
                'materia_id'=>$materia->id,
                'user_id'=>Auth::user()->id
            ])->get();
        }

        return view('calificacion.admin',[
            'materia' => $materia,
            'tiposCalificaciones' =>  $tiposCalificaciones,
            'calificaciones' => $calificaciones
        ]);
    }

    public function create($calificacion_id)
    {
        $calificacion = Calificacion::find($calificacion_id);
        $procesos = Proceso::where('materia_id',$calificacion->materia_id)->get();
        
        if($calificacion)
        {
            return view('calificacion.create',[
                'calificacion' => $calificacion,
                'procesos' => $procesos
            ]);
        }
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request,[
            'nombre' =>  ['required'],
            'tipo_id'=> ['required'],
            'fecha' => ['required']
        ]);

        $calificacion = Calificacion::create($request->all());

        return redirect()->route('calificacion.admin',[
            'materia_id' => $request['materia_id']
        ])->with('calificacion_creada','Calificación creada!');
    }
}
