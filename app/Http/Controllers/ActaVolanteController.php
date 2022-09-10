<?php

namespace App\Http\Controllers;

use App\Models\ActaVolante;
use App\Models\MesaAlumno;
use Illuminate\Http\Request;

class ActaVolanteController extends Controller
{
    public function store(Request $request)
    {
        $validate = $this->validate($request,[
            'nota_escrito' => ['alpha_num'],
            'nota_oral' => ['alpha_num'],
            'promedio' => ['alpha_num']
        ]);
        
        $inscripciones = MesaAlumno::where([
            'materia_id'=>$request['materia_id'],
            'estado_baja' => 0
        ])->get();
        $inscripciones_baja = MesaAlumno::select('nombres','apellidos','id','dni','alumno_id','updated_at')->where([
            'materia_id'=>$request['materia_id'],
            'estado_baja' => 1
        ])->get();

        $acta_volante = ActaVolante::create($request->all());

        return view('mesa.inscripciones_especial',[
            'inscripciones' => $inscripciones,
            'inscripciones_baja' => $inscripciones_baja,
            'materia' => $request['materia_id'],
            'instancia' => $request['instancia_id']
        ])->with('Se han colocado correctamente las notas');
    }
}
