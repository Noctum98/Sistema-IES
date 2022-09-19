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

        $request = $this->verificar_nota($request);

        $acta_volante = ActaVolante::create($request->all());

        return redirect()->back()->with(['alumno_success'=>'Se han colocado correctamente las notas']);
    }

    public function update(Request $request, $id)
    {
        $validate = $this->validate($request,[
            'nota_escrito' => ['alpha_num'],
            'nota_oral' => ['alpha_num'],
            'promedio' => ['alpha_num']
        ]);

        $request = $this->verificar_nota($request);

        $acta_volante = ActaVolante::find($id);

        $acta_volante->update($request->all());

        return redirect()->back()->with(['alumno_success'=>'Se han editado correctamente las notas']);
    }

    private function verificar_nota(Request $request)
    {
        if(!is_numeric($request['nota_escrito'])){
            $request['nota_escrito'] = -1;
        }

        if(!is_numeric($request['nota_oral'])){
            $request['nota_oral'] = -1;
        }

        if(!is_numeric($request['promedio'])){
            $request['promedio'] = -1;
        }

        return $request;
    }
}
