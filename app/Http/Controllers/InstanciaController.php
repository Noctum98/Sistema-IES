<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Instancia;
use App\Models\Sede;
use App\Models\Materia;
use App\Models\MesaAlumno;
use App\Models\Mesa;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\mesaAlumnosExport;

class InstanciaController extends Controller
{
    public function __construct(){
        $this->middleware('app.auth');
    }
    // Vistas

    public function vista_admin(){    
        $instancia = Instancia::all();
        $sedes = Sede::all();
        /*
        $sedes = Sede::where('id',7)
        ->orWhere('id',8)
        ->orWhere('id',13)
        ->get();
        */
        return view('mesa.admin',[
            'instancias'=>$instancia,
            'sedes' =>  $sedes
        ]);
    }
    public function vista_carreras($id){
        $sede = Sede::find($id);
        $instancia = session('instancia');

        $mesas = Mesa::where([
            'instancia_id'=>$instancia->id,
            
        ])->get();
    
        return view('mesa.carreras',[
            'sede'  =>  $sede,
            'instancia'=>$instancia
        ]);
    }
    //Funcionalidades
    public function crear(Request $request){
        $validate = $this->validate($request,[
            'nombre'    =>  ['required'],
            'limite'    =>  ['required','numeric'],
            'tipo'      =>  ['required','numeric']
        ]);

        $instancia = new Instancia();
        $instancia->nombre = $request->input('nombre');
        $instancia->tipo = $request->input('tipo');
        $instancia->limite = $request->input('limite');
        $instancia->estado = 'inactiva';
        $instancia->save();

        return redirect()->route('mesa.admin');
    }

    public function editar(Request $request,$id){
        $validate = $this->validate($request,[
            'nombre'    =>  ['required'],
            'limite'    =>  ['required','numeric'],
            'tipo'      =>  ['required','numeric']
        ]);
        $instancia = Instancia::find($id);
        $instancia->nombre = $request->input('nombre');
        $instancia->tipo = $request->input('tipo');
        $instancia->limite = $request->input('limite');
        $instancia->update();

        return redirect()->route('mesa.admin');
    }
    public function borrar($id){
        $instancia = Instancia::find($id);
        if($instancia->tipo == 0){
            Mesa::where('instancia_id',$id)->delete();
            DB::statement("ALTER TABLE mesas AUTO_INCREMENT = 1");
        }
        $mesa_alumnos = MesaAlumno::orderBy('materia_id','DESC')->where([
            'instancia_id' => $id
        ])->delete();

        return redirect()->route('mesa.admin')->with([
            'mensaje' => 'Datos borrados correctamente'
        ]);
    }
    public function cambiar_estado($estado,$id){
        $instancia = Instancia::find($id);
        $instancia->estado = $estado;
        $instancia->update();

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function descargar_excel($id){
        $inscripciones = MesaAlumno::where([
            'materia_id' => $id,
            'instancia_id' => session('instancia')->id
        ])->get();
        $materia = Materia::find($id);

        return Excel::download(
            new mesaAlumnosExport($inscripciones),
            'Inscripciones '.session('instancia')->nombre.'-'.$materia->nombre.'.xlsx'
        );
    }
    public function seleccionar_sede(Request $request,$id){
        $sede = Sede::find($request->input('sedes'));
        $instancia = Instancia::find($id);
        session(['instancia'=>$instancia]);

        return redirect()->route('mesa.carreras',[
            'id'=>$sede->id
        ]);
    }
}
