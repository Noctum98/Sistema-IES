<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Mesa;

class MesaController extends Controller
{
    // Vistas
    public function vista_inscripciones($id){
        $instancia = session('instancia');
        $primer_llamado = [];
        $segundo_llamado = [];

        $mesa = Mesa::where([
            'id' => $id,
        ])->first();

        foreach($mesa->mesa_inscriptos as $inscripcion){
            if($inscripcion->segundo_llamado){
                array_push($segundo_llamado,$inscripcion);
            }else{
                array_push($primer_llamado,$inscripcion);
            }
        }

        return view('mesa.inscripciones',[
            'mesa' => $mesa,
            'primer_llamado' => $primer_llamado,
            'segundo_llamado' => $segundo_llamado
        ]);
    }
    // Funcionalidades
    public function crear(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'fecha' => ['required'],
            'presidente'    => ['required', 'string'],
            'primer_vocal'  => ['required', 'string'],
            'segundo_vocal' => ['required', 'string']
        ]);

        $materia = Materia::find($id);
        $instancia = session('instancia');

        $mesa_verified = Mesa::where([
            'materia_id' => $id,
            'instancia_id' => $instancia->id
        ])->first();

        if($mesa_verified){
            return redirect()->route('mesa.carreras', [
                'id' => $materia->carrera->sede->id
            ]);
        }
 
        $mesa = new Mesa();
        $mesa->instancia_id = $instancia->id;
        $mesa->materia_id = $materia->id;
        $mesa->presidente = $request->input('presidente');
        $mesa->primer_vocal = $request->input('primer_vocal');
        $mesa->segundo_vocal = $request->input('segundo_vocal');
        $mesa->fecha = $request->input('fecha');
        $mesa->fecha_segundo = $request->input('fecha_segundo') ? $request->input('fecha_segundo'): null;
        $mesa->presidente_segundo = $request->input('presidente_segundo') ? $request->input('presidente_segundo'): null;
        $mesa->primer_vocal_segundo = $request->input('primer_vocal_segundo') ? $request->input('primer_vocal_segundo') : null;
        $mesa->segundo_vocal_segundo = $request->input('segundo_vocal_segundo') ? $request->input('segundo_vocal_segundo') : null;

        if (date('D', strtotime($mesa->fecha)) == 'Mon' || date('D', strtotime($mesa->fecha)) == 'Tue') {
            $mesa->cierre = strtotime($mesa->fecha . "-4 days");
        } else {
            $mesa->cierre = strtotime($mesa->fecha . "-2 days");
        }
        if ($request->input('fecha_segundo') && date('D', strtotime($mesa->fecha_segundo)) == 'Mon' || date('D', strtotime($mesa->fecha_segundo)) == 'Tue') {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-4 days");
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

    public function editar(Request $request, $id){

        $validate = $this->validate($request, [
            'fecha' => ['required'],
            'presidente'    => ['required', 'string'],
            'primer_vocal'  => ['required', 'string'],
            'segundo_vocal' => ['required', 'string']
        ]);

        $mesa = Mesa::where('materia_id',$id)->first();

        $mesa->presidente = $request->input('presidente');
        $mesa->primer_vocal = $request->input('primer_vocal');
        $mesa->segundo_vocal = $request->input('segundo_vocal');
        $mesa->fecha = $request->input('fecha');
        $mesa->fecha_segundo = $request->input('fecha_segundo');
        $mesa->presidente_segundo = $request->input('presidente_segundo');
        $mesa->primer_vocal_segundo = $request->input('primer_vocal_segundo');
        $mesa->segundo_vocal_segundo = $request->input('segundo_vocal_segundo');

        if (date('D', strtotime($mesa->fecha)) == 'Mon' || date('D', strtotime($mesa->fecha)) == 'Tue') {
            $mesa->cierre = strtotime($mesa->fecha . "-4 days");
        } else {
            $mesa->cierre = strtotime($mesa->fecha . "-2 days");
        }
        if (date('D', strtotime($mesa->fecha_segundo)) == 'Mon' || date('D', strtotime($mesa->fecha_segundo)) == 'Tue') {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-4 days");
        } else {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-2 days");
        }
        $mesa->update();

        return redirect()->route('mesa.carreras', [
            'id' => $mesa->materia->carrera->sede->id
        ])->with([
            'message_edit' => 'Mesa ' . $mesa->materia->nombre . ' editada correctamente'
        ]);
    }
}
