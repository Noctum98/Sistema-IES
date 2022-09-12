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
        

        $acta_volante = ActaVolante::create($request->all());

        return redirect()->back()->with('Se han colocado correctamente las notas');
    }
}
