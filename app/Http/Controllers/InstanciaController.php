<?php

namespace App\Http\Controllers;

use App\Exports\excelTribunalExport;
use Illuminate\Http\RedirectResponse;
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
use App\Http\Requests\InstanciaRequest;
use App\Models\User;
use App\Services\Mesas\InstanciaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InstanciaController extends Controller
{
    private $instanciaService;

    public function __construct(
        InstanciaService $instanciaService
    )
    {
        $this->middleware('app.auth');
        $this->instanciaService = $instanciaService;
    }
    // Vistas

    public function vista_admin(Request $request,$todos = null)
    {
        $sedes = Auth::user()->sedes;
        $carreras = Auth::user()->carreras->pluck('id');

        //dd($carreras->toArray());
        if(!$todos)
        {
            $instancia = Instancia::where(function ($query) use ($carreras) {
                $query->where('general', 1)
                    ->orWhereHas('carreras', function ($query) use ($carreras) {
                        $query->whereIn('carreras.id', $carreras);
                    });
                })
                ->orderBy('id','desc')->take(4)->get();
            if(Session::has('admin') || Session::has('regente'))
            {
                $instancia = Instancia::orderBy('id','desc')->take(4)->get();
            }
        }else{
            $instancia = Instancia::where(function ($query) use ($carreras) {
                $query->where('general', 1)
                    ->orWhereHas('carreras', function ($query) use ($carreras) {
                        $query->whereIn('carreras.id', $carreras);
                    });
                })
                ->orderBy('id','desc')->get();

            if(Session::has('admin') || Session::has('regente'))
            {
                $instancia = Instancia::orderBy('id','desc')->get();

            }
        }
        return view('mesa.admin', [
            'instancias' => $instancia,
            'sedes' =>  $sedes,
            'todos' => $todos
        ]);
    }

    public function vista_carreras($sede_id,$instancia_id)
    {

        $sede = Sede::find($sede_id);
        $instancia = Instancia::find($instancia_id);
        $user_carreras =  Auth::user()->carreras;

        if($instancia->general)
        {
            if(Session::has('admin') || Session::has('areaSocial') || Session::has('regente'))
            {
                $carreras = $sede->carreras;
            }else{
                $carreras = $user_carreras;
            }
        }else{

            if(Session::has('admin')){
                $carreras = $instancia->carreras;
            }else{
                $carreras = [];
                foreach($instancia->carreras as $carrera)
                {
                    $carreraExistente = $user_carreras->contains('id', $carrera->id);
    
                    if($carreraExistente)
                    {
                        array_push($carreras,$carrera);
                    }
    
                }
            }
            
        }
        

        return view('mesa.carreras', [
            'sede'  =>  $sede,
            'instancia' => $instancia,
            'carreras' => $carreras,
        ]);
    }

    public function vista_mesas(Request $request,$id,$instancia_id)
    {
       $carrera = Carrera::find($id);
       $instancia = Instancia::find($instancia_id);
       $profesores = User::select('id','nombre','apellido')->whereHas('carreras',function($query) use ($carrera){
            $query->where([
                'carreras.resolucion'=>$carrera->resolucion,
                'carreras.sede_id'=>$carrera->sede_id
            ]);
       })->get();

        return view('mesa.admin_mesa',[
            'carrera' => $carrera,
            'instancia' => $instancia,
            'profesores' => $profesores
        ]);
    }

    //Funcionalidades
    public function crear(InstanciaRequest $request)
    {
        $request['estado'] = 'inactiva';

        $request['general'] = isset($request['general']) ? $request['general'] : false;

        $instancia = Instancia::create($request->all());


        if(!$request['general'])
        {
            $this->instanciaService->agregarSedes($request,$instancia);
            $this->instanciaService->agregarCarreras($request,$instancia);
        }

        return redirect()->back()->with('alert_success','Instancia creada correctamente.');
    }

    public function editar(InstanciaRequest $request, $id)
    {
        $request['general'] = isset($request['general']) ? $request['general'] : false;
        $instancia = Instancia::find($id);
        $instancia->update($request->all());

        if(!$request['general'])
        {
            $this->instanciaService->agregarSedes($request,$instancia);
            $this->instanciaService->agregarCarreras($request,$instancia);
        }

        return redirect()->back()->with('alert_success','Instancia editada correctamente.');
    }

    public function borrar(Instancia $id, $solo = null): RedirectResponse
    {
        if($id->tipo == 1){
            $mesaAlumno = MesaAlumno::where('instancia_id', $id->id)->get();
            foreach ($mesaAlumno as $ma)
            {
                $ma->delete();
            }
        }

        return redirect()->route('mesa.admin')->with([
            'mensaje' => sprintf('Datos de %s fueron borrados correctamente', $id->nombre)
        ]);
    }

    public function getInstancia(Request $request,$id)
    {
        $instancia = Instancia::where('id',$id)->with('sedes','carreras')->first();

        return response()->json($instancia,200);
    }

    public function cambiar_estado($estado, $id)
    {
        $instancia = Instancia::find($id);
        $instancia->estado = $estado;
        $instancia->update();

        return response()->json([
            'status' => 'success',
            'data' => $instancia
        ]);
    }


    public function cambiar_cierre($cierre,$id){
        $instancia = Instancia::find($id);
        $instancia->cierre = $cierre;
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
            $inscripciones = MesaAlumno::with(['acta_volante','alumno'=>function($query){
                $query->orderBy('apellidos','asc');
            }])->where([
                'mesa_id' => $id,
                'segundo_llamado' => $segundo_llamado,
                'estado_baja' => false,
                'confirmado' => true
            ])->get();

            $materia = $mesa->materia;
        } else {

            $inscripciones = MesaAlumno::with(['acta_volante','alumno'=>function($query){
                $query->orderBy('apellidos','asc');
            }])->where([
                'materia_id' => $id,
                'instancia_id' => $instancia->id,
                'estado_baja' => false,
                'confirmado' => true
            ])->get();
            $materia = Materia::find($id);
        }

        return Excel::download(
            new mesaAlumnosExport($inscripciones, $materia),
            'Inscripciones ' . $instancia->nombre . '-' . $materia->nombre.' - '.$materia->carrera->nombre . '.xlsx'
        );
    }
    public function descargar_tribunal($carrera,$instancia_id)
    {
        $carrera = Carrera::find($carrera);
        $instancia = Instancia::find($instancia_id);



        if ($carrera) {
            $excel = Excel::download(
                new excelTribunalExport($carrera,$instancia),
                'Mesas ' . $carrera->nombre . '-' . $carrera->sede->nombre . '(' . $instancia->nombre . ').xlsx'
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
