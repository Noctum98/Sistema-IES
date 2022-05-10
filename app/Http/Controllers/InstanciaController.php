<?php

namespace App\Http\Controllers;

use App\Exports\excelMultipleTribunalExport;
use App\Exports\excelTribunalExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Instancia;
use App\Models\Sede;
use App\Models\Materia;
use App\Models\MesaAlumno;
use App\Models\Mesa;
use App\Models\Carrera;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\mesaAlumnosExport;
use App\Exports\totalInscripcionesExport;
use Illuminate\Support\Facades\Auth;

class InstanciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
    }
    // Vistas

    public function vista_admin()
    {
        $instancia = Instancia::all();
        $sedes = Auth::user()->sedes;
        /*
        $sedes = Sede::where('id',7)
        ->orWhere('id',8)
        ->orWhere('id',13)
        ->get();
        */
        return view('mesa.admin', [
            'instancias' => $instancia,
            'sedes' =>  $sedes
        ]);
    }
    public function vista_carreras($sede_id,$instancia_id)
    {
        $sede = Sede::find($sede_id);
        $instancia = Instancia::find($instancia_id);

        return view('mesa.carreras', [
            'sede'  =>  $sede,
            'instancia' => $instancia
        ]);
    }
    //Funcionalidades
    public function crear(Request $request)
    {
        $validate = $this->validate($request, [
            'nombre'    =>  ['required'],
            'limite'    =>  ['required', 'numeric'],
            'tipo'      =>  ['required', 'numeric']
        ]);

        $instancia = new Instancia();
        $instancia->nombre = $request->input('nombre');
        $instancia->tipo = $request->input('tipo');
        $instancia->limite = $request->input('limite');
        if ($instancia->tipo == 0) {
            $instancia->segundo_llamado = $request->input('segundo_llamado');
        }
        $instancia->estado = 'inactiva';
        $instancia->save();

        return redirect()->route('mesa.admin');
    }

    public function editar(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'nombre'    =>  ['required'],
            'limite'    =>  ['required', 'numeric'],
            'tipo'      =>  ['required', 'numeric'],
        ]);
        $instancia = Instancia::find($id);
        $instancia->nombre = $request->input('nombre');
        $instancia->tipo = $request->input('tipo');
        $instancia->limite = $request->input('limite');
        if ($instancia->tipo == 0) {
            $instancia->segundo_llamado = $request->input('segundo_llamado');
        }
        $instancia->update();

        return redirect()->route('mesa.admin');
    }
    public function borrar($id, $solo = null)
    {
        $instancia = Instancia::find($id);
        if ($instancia->tipo == 0 && !$solo) {
            Mesa::where('instancia_id', $id)->delete();
            DB::statement("ALTER TABLE mesas AUTO_INCREMENT = 1");
        }
        $mesa_alumnos = MesaAlumno::truncate();

        return redirect()->route('mesa.admin')->with([
            'mensaje' => 'Datos borrados correctamente'
        ]);
    }
    public function cambiar_estado($estado, $id)
    {
        $instancia = Instancia::find($id);
        $instancia->estado = $estado;
        $instancia->update();

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function descargar_excel($id,$instancia_id,$llamado=null)
    {
        $instancia = $instancia_id ? Instancia::find($instancia_id) : session('instancia');

        if ($instancia->tipo == 0) {
            $mesa = Mesa::find($id);
            if($llamado == 'primero'){
                $segundo_llamado = false;
            }else{
                $segundo_llamado = true;
            }
            $inscripciones = MesaAlumno::where([
                'mesa_id' => $id,
                'segundo_llamado' => $segundo_llamado
            ])->get();
     
            $materia = $mesa->materia;
        } else {
  
            $inscripciones = MesaAlumno::where([
                'materia_id' => $id,
                'instancia_id' => $instancia->id,
                'estado_baja' => false
            ])->get();
            $materia = Materia::find($id);
        }

        return Excel::download(
            new mesaAlumnosExport($inscripciones, $materia),
            'Inscripciones ' . $instancia->nombre . '-' . $materia->nombre.' - '.$materia->carrera->nombre . '.xlsx'
        );
    }
    public function descargar_tribunal($carrera)
    {
        $carrera = Carrera::find($carrera);
        $instancia = session('instancia');

        if (time() > strtotime($instancia->segundo_llamado)) {
            $llamado = "Segundo llamado";
        } else {
            $llamado = "Primer llamado";
        }

        if ($carrera) {
            $excel = Excel::download(
                new excelTribunalExport($carrera),
                'Mesas ' . $carrera->nombre . '-' . $carrera->sede->nombre . '(' . $llamado . ').xlsx'
            );
        }

        //Prueba
        return $excel;
    }
    public function descargar_total($sede_id){
        $carreras = Carrera::where('sede_id',$sede_id)->get();
        $sede = Sede::find($sede_id);

        return Excel::download(
            new totalInscripcionesExport($carreras),
            'Inscripciones mesas de '.$sede->nombre.'.xlsx'
        );
    }
    public function seleccionar_sede(Request $request, $id)
    {
        $sede = Sede::find($request->input('sedes'));
        $instancia = Instancia::find($id);

        return redirect()->route('mesa.carreras', [
            'sede_id' => $sede->id,
            'instancia_id' => $instancia->id
        ]);
    }
}
