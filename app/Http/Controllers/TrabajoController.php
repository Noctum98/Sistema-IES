<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Trabajo;
use App\Models\Materia;
use App\Models\Proceso;
use Illuminate\Support\Facades\Auth;

class TrabajoController extends Controller
{
    function __construct()
    {
        $this->middleware('app.admin');
    }
    // Vistas
    public function vista_carreras(){
        $sedes = Auth::user()->sedes;
        $ruta = 'trab.admin';

        return view('trabajo.home',[
            'sedes'  =>  $sedes,
            'ruta'      =>  $ruta
        ]);
    }

    public function vista_admin(int $id){
        $materia = Materia::find($id);
        $trabajos = Trabajo::orderBy('id','asc')->where('materia_id',$materia->id)->get(); 

        return view('trabajo.admin',[
            'materia'   =>  $materia,
            'trabajos'  =>  $trabajos
        ]);
    }

    public function vista_crear(int $id){
        $materia = Materia::find($id);

        return view('trabajo.create',[
            'materia'   =>  $materia
        ]); 
    }
    public function vista_editar(int $id){
        $trabajo = Trabajo::find($id);

        return view('trabajo.edit',[
            'trabajo'   =>  $trabajo
        ]);
    }
    public function vista_notas(int $id){
        $trabajo = Trabajo::find($id);
        $procesos = Proceso::where('materia_id',$trabajo->materia_id)->get();

        return view('trabajo.notas',[
            'trabajo'   =>  $trabajo,
            'procesos'  =>  $procesos
        ]);
    }
    // Funcionalidades
    public function crear(Request $request,int $id){
        $validate = $this->validate($request,[
            'nombre'    =>  ['required','string'],
            'fecha'     =>  ['required','string']
        ]);

        $trabajo = new Trabajo();
        $trabajo->materia_id = $id;
        $trabajo->nombre = $request->input('nombre');
        $trabajo->fecha = $request->input('fecha');
        $trabajo->save();

        return redirect()->route('trab.notas',['id'=>$trabajo->id]);
    }
}
