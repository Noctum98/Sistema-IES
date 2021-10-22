<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Mesa;

class MesaController extends Controller
{
    // Funcionalidades
    public function crear(Request $request,$id){
        $validate = $this->validate($request,[
            'fecha' => ['required']
        ]);


        $materia = Materia::find($id);
        $instancia = session('instancia');

        $mesa = Mesa::where([
            'materia_id'=>$materia->id,
            'instancia_id'=>$instancia->id
        ])->first();

        if($mesa){
            $mesa->fecha = $request->input('fecha');
            if(date('D',strtotime($mesa->fecha)) == 'Mon'){
                $mesa->cierre = strtotime($mesa->fecha."-3 days");
            }else{
                $mesa->cierre = strtotime($mesa->fecha."-2 days");
            }
            $mesa->update();
        }else{
            $mesa = new Mesa();
            $mesa->instancia_id = $instancia->id;
            $mesa->materia_id = $materia->id;
            $mesa->fecha = $request->input('fecha');
             if(date('D',strtotime($mesa->fecha)) == 'Mon'){
                $mesa->cierre = strtotime($mesa->fecha."-3 days");
            }else{
                $mesa->cierre = strtotime($mesa->fecha."-2 days");
            }
            $mesa->save();
        }    
        
        return redirect()->route('mesa.carreras',[
            'id'=>$materia->carrera->sede->id
        ])->with([
            'message'=>'Mesa '.$materia->nombre.' configurada correctamente'
        ]);
    }
}
