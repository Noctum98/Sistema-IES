<?php

namespace App\Http\Controllers;
use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Proceso;

use Illuminate\Http\Request;

class ProcesoController extends Controller
{
    function __construct()
    {
        $this->middleware('app.admin');
    }
    // Vistas
    public function vista_inscribir($id){
        $alumno = Alumno::find($id);
        $materias = Materia::where('carrera_id',$alumno->carrera_id)->get();
        $procesos = Proceso::orderBy('estado')->where('alumno_id',$alumno->id)->get();
        $mis_materias = [];
        $mis_materias = $materias->toArray();
        
        for($contador = 0;$contador< count($mis_materias);$contador++){
            foreach($procesos as $proceso){
               if($proceso->materia_id == $mis_materias[$contador]['id']){
                    unset($mis_materias[$contador]);
                    $mis_materias = array_values($mis_materias);
               }
            }
        }

        return view('alumno.enroll',[
            'alumno'    =>  $alumno,
            'materias'  =>  $mis_materias,
            'procesos'  => $procesos,
        ]);
    }

    public function vista_detalle(int $id){
        $proceso = Proceso::find($id);

        return view('proceso.detail',[
            'proceso'   =>  $proceso
        ]);
    }

    // Funcionalidades
    public function inscribir(int $alumno_id,int $materia_id){
        $proceso = new Proceso();
        $proceso->alumno_id = $alumno_id;
        $proceso->materia_id = $materia_id;
        $proceso->estado = 'en curso';

        $proceso->save();

        return redirect()->route('proceso.inscribir',['id'=>$alumno_id])->with([
            'message'   =>  'Inscrito con éxito!'
        ]);
    }
}
