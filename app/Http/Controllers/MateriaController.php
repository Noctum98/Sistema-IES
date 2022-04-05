<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Personal;
use App\Models\Materia;

class MateriaController extends Controller
{
    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin');
    }
    // Vistas

    public function vista_admin(int $carrera_id){
        $carrera = Carrera::find($carrera_id);
        $materias = Materia::where('carrera_id',$carrera_id)->orderBy('año')->get();

        return view('materia.admin',[
            'carrera'   =>  $carrera,
            'materias'  =>  $materias
        ]);
    }
    public function vista_crear(int $carrera_id){
        $carrera =  Carrera::find($carrera_id);
        $personal = Personal::where('sede_id',$carrera->sede_id)->get();
        $materias = Materia::where('carrera_id',$carrera_id)->get();

        return view('materia.create',[
            'carrera'   => $carrera,
            'personal'  => $personal,
            'materias'  => $materias
        ]);
    }
    public function vista_editar(int $id){
        $materia =  Materia::find($id);
        $personal = Personal::where('sede_id',$materia->carrera->sede_id)->get();
        $materias = Materia::where('carrera_id',$materia->carrera_id)->get();

        return view('materia.edit',[
            'materia'   =>  $materia,
            'personal'  => $personal,
            'materias'  => $materias
        ]);
    }

    // Funcionalidades

    public function crear(int $carrera_id,Request $request){
        $validate = $this->validate($request,[
            'nombre'    => ['required'],
            'año'       => ['required','numeric','max:3'],
            'personal'  => ['numeric']
        ]);

        $materia = new Materia();
        $materia->nombre = $request->input('nombre');
        $materia->año = (int) $request->input('año');
        $materia->carrera_id = $carrera_id;
        $materia->personal_id = (int) $request->input('personal');
        $materia->correlativa = $request->input('correlativa');

        $materia->save();

        return redirect()->route('materia.admin',['carrera_id'=>$carrera_id]);
    }
    public function editar(int $id, Request $request){
        $validate = $this->validate($request,[
            'nombre'    => ['required'],
            'año'       => ['required','numeric','max:3'],
            'personal'  => ['required','numeric']
        ]);
        $materia = Materia::find($id);
        $materia->nombre = $request->input('nombre');
        $materia->año = (int) $request->input('año');
        $materia->personal_id = (int) $request->input('personal');
        $materia->correlativa = $request->input('correlativa');

        $materia->update();

        return redirect()->route('materia.editar',['id'=>$id])->with([
            'message'   =>  'Materia editada correctamente!'
        ]);
    }

    public function selectMaterias($id)
    {
        $materias = Materia::select('nombre','id')->where('carrera_id',$id)->get();

        return response()->json($materias,200);
    }
}