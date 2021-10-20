<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;

class SedeController extends Controller
{
    //Vistas
    public function vista_sedes(){
        $sedes = Sede::all();

        return view('sede.sedes',[
            'sedes' => $sedes
        ]);
    }

    public function vista_crear(){
        return view('sede.create');
    }

    public function vista_editar(int $id){
        $sede = Sede::find($id);

        return view('sede.edit',[
            'sede' => $sede
        ]);
    }

    // Funcionalidades
    public function crear(Request $request){

        $validate = $this->validate($request,[
            'nombre' => ['required'],
            'ubicacion' => ['required'],
        ]);

        if(\Auth::user()->rol == 'rol_admin'){
            $sede = new Sede();
            $sede->nombre = $request->nombre;
            $sede->ubicacion = $request->ubicacion;
            $sede->save(); 
        }else{
            return redirect()->route('sedes.crear')->with([
                'error'=>'No eres usuario administrador'
            ]);
        }

        return redirect()->route('sedes.crear')->with([
                'message'=>'Sede creada correctamente!'
        ]); 
    }

    public function editar(Request $request,int $id){

        $validate = $this->validate($request,[
            'nombre' => ['required'],
            'ubicacion' => ['required'],
        ]);

        if(\Auth::user()->rol == 'rol_admin'){
            $sede = Sede::find($id);
            $sede->nombre = $request->nombre;
            $sede->ubicacion = $request->ubicacion;
            $sede->update(); 
        }else{
            return redirect()->route('sedes.editar',['id'=>$sede->id])->with([
                'error'=>'No eres usuario administrador'
            ]);
        }

        return redirect()->route('sedes.editar',['id'=>$sede->id])->with([
                'message'=>'Sede editada correctamente!'
        ]);
    }

    public function eliminar(int $id){
        $sede = Sede::find($id)->delete();

        return redirect()->route('sedes.admin')->with([
            'sede_deleted' => 'Sede elimindada!'
        ]);
    }
}
