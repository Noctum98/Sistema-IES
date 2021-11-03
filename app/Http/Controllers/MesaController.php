<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Mesa;

class MesaController extends Controller
{
    // Funcionalidades
    public function crear(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'fecha' => ['required'],
            'fecha_segundo' => ['required'],
            'presidente'    => ['required', 'string'],
            'primer_vocal'  => ['required', 'string'],
            'segundo_vocal' => ['required', 'string']
        ]);

        $materia = Materia::find($id);
        $instancia = session('instancia');

        $mesa = new Mesa();
        $mesa->instancia_id = $instancia->id;
        $mesa->materia_id = $materia->id;
        $mesa->presidente = $request->input('presidente');
        $mesa->primer_vocal = $request->input('primer_vocal');
        $mesa->segundo_vocal = $request->input('segundo_vocal');
        $mesa->fecha = $request->input('fecha');
        $mesa->fecha_segundo = $request->input('fecha_segundo');
        if (date('D', strtotime($mesa->fecha)) == 'Mon') {
            $mesa->cierre = strtotime($mesa->fecha . "-3 days");
        } else {
            $mesa->cierre = strtotime($mesa->fecha . "-2 days");
        }
        if (date('D', strtotime($mesa->fecha_segundo)) == 'Mon') {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-3 days");
        } else {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-2 days");
        }
        $mesa->save();

        return redirect()->route('mesa.carreras', [
            'id' => $materia->carrera->sede->id
        ])->with([
            'message' => 'Mesa ' . $materia->nombre . ' configurada correctamente'
        ]);
    }
}
