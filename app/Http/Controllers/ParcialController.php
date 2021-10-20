<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Parcial;
use App\Models\Proceso;

class ParcialController extends Controller
{
    // Vistas
    function __construct()
    {
        $this->middleware('app.admin');
    }
    public function vista_carreras(){
        $carreras = Carrera::orderBy('sede_id','asc')->get();
        $ruta = 'parci.admin';

        return view('parcial.home',[
            'carreras'  =>  $carreras,
            'ruta'      =>  $ruta
        ]);
    }

    public function vista_admin(int $id){
        $materia = Materia::find($id);
        $parciales = Parcial::where('materia_id',$materia->id)->get();

        return view('parcial.admin',[
            'materia'   =>  $materia,
            'parciales' =>  $parciales
        ]);
    }

   public function vista_crear(int $id){
        $materia = Materia::find($id);

        return view('parcial.create',[
            'materia'   =>  $materia
        ]); 
    }
    public function vista_notas(int $id){
        $parcial = Parcial::find($id);
        $procesos = Proceso::where('materia_id',$parcial->materia_id)->get();

        return view('parcial.notas',[
            'parcial'   =>  $parcial,
            'procesos'  =>  $procesos
        ]);
    }
    public function vista_editar(int $id){
        $parcial = Parcial::find($id);

        return view('parcial.edit',[
            'parcial'   =>  $parcial
        ]);
    }
    public function vista_recuperatorio(int $id){
        $parcial = Parcial::find($id);

        return view('parcial.recuperatorio',[
            'parcial'   =>  $parcial
        ]);
    }
    // Funcionalidades

    public function crear(Request $request,int $materia_id){
        $validate = $this->validate($request,[
            'nombre'    =>  ['required','numeric'],
            'fecha'     =>  ['required','string']
        ]);

        $parcial = new Parcial();
        $parcial->materia_id = $materia_id;
        $parcial->nombre = 'Parcial N° '.$request->input('nombre');
        $parcial->fecha = $request->input('fecha');
        $parcial->save();

        return redirect()->route('parci.notas',[
            'id'    =>  $parcial->id
        ]);
    }
}
