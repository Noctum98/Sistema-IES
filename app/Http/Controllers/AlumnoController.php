<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    public function __construct(){
        $this->middleware('app.auth',['except'=>['descargar_archivo','descargar_ficha']]);
        $this->middleware('app.roles:admin-coordinador-regente-seccionAlumnos',['only'=>['vista_admin','vista_alumnos','vista_elegir']]);
    }
    // Vistas
    public function vista_admin($busqueda = null){
        $user = Auth::user();
        $alumnos = [];
        $sedes = null;

        if(!empty($busqueda)){
            $alumnos = Alumno::where('dni','LIKE','%'.$busqueda.'%')
                            ->orWhere('nombres','LIKE','%'.$busqueda.'%')
                            ->orWhere('apellidos','LIKE','%'.$busqueda.'%')
                            ->orWhere('telefono','LIKE','%'.$busqueda.'%')
                            ->select('nombres','apellidos','id','dni')
                            ->get();
        }else{
            $sedes = $user->sedes;
        }

        return view('alumno.admin',[
            'alumnos' => $alumnos,
            'sedes'=> $sedes,
            'busqueda'=> $busqueda
        ]);
    }

    public function vista_elegir(){
        $carreras = Carrera::orderBy('sede_id')->get();
        return view('alumno.choice',[
            'carreras' => $carreras
        ]);
    }

    public function vista_crear(int $id){
        $carrera = Carrera::find($id);
        return view('alumno.create',[
            'carrera' => $carrera
        ]);
    }

    public function vista_editar(int $id){
        $alumno = Alumno::find($id);
        $carreras = Carrera::all();

        return view('alumno.edit',[
            'alumno'    =>  $alumno,
            'carreras'  =>  $carreras
        ]);
    }

    public function vista_alumnos(Request $request,$carrera_id){
        $carrera = Carrera::find($carrera_id);

        return view('alumno.alumnos',[
            'carrera'   =>  $carrera
        ]);
    }

    public function vista_detalle(int $id){
        $alumno = Alumno::find($id);

        if(!$alumno)
        {
            return redirect()->route('alumno.admin')->with([
                'alumno_notIsset' => 'El alumno no existe'
            ]);
        }

        return view('alumno.detail',[
            'alumno'    =>  $alumno
        ]);
    }

    public function ver_foto(string $foto): Response
    {
        $archivo = Storage::disk('alumno_foto')->get($foto);

        return new Response($archivo,200);
    }
    public function descargar_archivo(string $nombre,string $disco){

        $exists = Storage::disk($disco)->exists($nombre);

        if($exists){
           $archivo = Storage::disk($disco)->path($nombre);
           return response()->file($archivo);
        }else{
            return redirect()->route('alumno.detalle');
        }
    }
    public function descargar_ficha(int $id){
        $alumno = Alumno::find($id);

        if($alumno)
        {
            $data = [
                'alumno' => $alumno
            ];

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.alumno_ficha',$data);

            return $pdf->download('Ficha '.$alumno->nombres.' '.$alumno->apellidos.'.pdf');
        }else{
            return view('error.error');
        }
    }
}
