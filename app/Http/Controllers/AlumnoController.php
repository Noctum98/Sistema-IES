<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AlumnoController extends Controller
{
    public function __construct(){
        $this->middleware('app.admin',['except'=>['descargar_archivo']]);
    }
    // Vistas
    public function vista_admin($busqueda = null){
        $alumnos = [];
        $carreras = [];

        if(!empty($busqueda)){
            $alumnos = Alumno::where('dni','LIKE','%'.$busqueda.'%')
                            ->orWhere('nombres','LIKE','%'.$busqueda.'%')
                            ->orWhere('apellidos','LIKE','%'.$busqueda.'%')
                            ->orWhere('residencia','LIKE','%'.$busqueda.'%')
                            ->orWhere('nombres','LIKE','%'.$busqueda.'%')
                            ->orWhere('telefono','LIKE','%'.$busqueda.'%')
                            ->get();
        }else{
            $carreras = Carrera::all();
        }

        return view('alumno.admin',[
            'alumnos' => $alumnos,
            'carreras'=> $carreras,
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
    public function vista_alumnos(Request $request,int $carrera_id){
        $alumnos = Alumno::where('carrera_id',$carrera_id)->get();
        $carrera = Carrera::find($carrera_id);

        return view('alumno.alumnos',[
            'alumnos'   =>  $alumnos,
            'carrera'   =>  $carrera
        ]);
    }
    public function vista_detalle(int $id){
        $alumno = Alumno::find($id);

        return view('alumno.detail',[
            'alumno'    =>  $alumno
        ]);
    }
    

    // Funcionalidades
    public function crear(Request $request,int $carrera_id){
        
        $validate = $this->validate($request,[
            'año'           =>  ['required','numeric','max:3'],
            'nombres'       =>  ['required'],
            'apellidos'     =>  ['required'],
            'dni'           =>  ['required','numeric','unique:alumnos'],
            'telefono'      =>  ['required','numeric'],
            'fecha'         =>  ['required'],
            'email'         =>  ['required','email'],
        ]);


        $alumno = new Alumno();

        $alumno->año = $request->año;
        $alumno->carrera_id = $carrera_id;
        $alumno->nombres = $request->input('nombres');
        $alumno->apellidos = $request->input('apellidos');
        $alumno->dni = $request->input('dni');
        $alumno->fecha = $request->input('fecha');
        $alumno->telefono = $request->input('telefono');
        $alumno->email = $request->input('email');

        $alumno->save();

        return redirect()->route('alumno.crear',['id'=>$carrera_id])->with([
            'message' => 'El alumno ha sido inscripto con éxito!'
        ]);

    }
    public function editar(Request $request,int $id){
        $validate = $this->validate($request,[
            'año'           =>  ['numeric','max:3'],
            'nombres'       =>  ['required'],
            'apellidos'     =>  ['required'],
            'dni'           =>  ['required','numeric',Rule::unique('alumnos')->ignore($id)],
            'cuil'          =>  ['required','numeric',Rule::unique('alumnos')->ignore($id)],
            'fecha'         =>  ['required'],
            'email'         =>  ['required','email'],
            'edad'          =>  ['required','numeric'],
            'nacionalidad'  =>  ['required'],
            'domicilio'     =>  ['required'],
            'residencia'    =>  ['required'],
            'telefono'      =>  ['required','numeric'],
            'condicion_s'   =>  ['required'],
            'escolaridad'   =>  ['required'],
            'escuela_s'     =>  ['required'],
            'materias_s'     =>  ['required'],
            'conexion'      =>  ['required'],
            'imagen'        =>  ['mimes:jpg,jpeg,png,gif'] 
        ]);

        $alumno = Alumno::find($id);

        $dni_archivo = $request->file('dni_archivo');
        $partida_archivo = $request->file('partida_archivo');
        $imagen_archivo = $request->file('imagen');
        $titulo_archivo = $request->file('titulo_archivo');
        $certificado_archivo = $request->file('certificado_archivo');
        $psicofisico_archivo = $request->file('psicofisico');

        if($dni_archivo){
            $dni_nombre = time().$dni_archivo->getClientOriginalName();

            Storage::disk('alumno_dni')->delete($alumno->dni_archivo);
            Storage::disk('alumno_dni')->put($dni_nombre,File::get($dni_archivo));
            $alumno->dni_archivo = $dni_nombre;
        }

        if($partida_archivo){
            $partida_nombre = time().$partida_archivo->getClientOriginalName();

            Storage::disk('alumno_partida')->delete($alumno->partida_archivo);
            Storage::disk('alumno_partida')->put($partida_nombre,File::get($partida_archivo));
            $alumno->partida_archivo = $partida_nombre;
        }

        if($imagen_archivo){
            $imagen_nombre = time().$imagen_archivo->getClientOriginalName();

            Storage::disk('alumno_foto')->delete($alumno->imagen);
            Storage::disk('alumno_foto')->put($imagen_nombre,File::get($imagen_archivo));
            $alumno->imagen = $imagen_nombre;
        }

        if($titulo_archivo){
            $titulo_nombre = time().$titulo_archivo->getClientOriginalName();

            Storage::disk('alumno_titulo')->delete($alumno->titulo_archivo);
            Storage::disk('alumno_titulo')->put($titulo_nombre,File::get($titulo_archivo));
            $alumno->titulo_archivo = $titulo_nombre;
        }

        if($certificado_archivo){
            $certificado_nombre = time().$certificado_archivo->getClientOriginalName();

            Storage::disk('alumno_certificado')->delete($alumno->certificado_archivo);
            Storage::disk('alumno_certificado')->put($certificado_nombre,File::get($certificado_archivo));
            $alumno->certificado_archivo = $certificado_nombre;
        }

        if($psicofisico_archivo){
            $psicofisico_nombre = time().$psicofisico_archivo->getClientOriginalName();

            Storage::disk('alumno_psicofisico')->delete($alumno->psicofisico_archivo);
            Storage::disk('alumno_psicofisico')->put($psicofisico_nombre,File::get($psicofisico_archivo));
            $alumno->psicofisico_archivo = $psicofisico_nombre;
        }

        $alumno->año = $request->año ? $request->año : null;
        $alumno->carrera_id = (int) $request->input('carrera_id');
        $alumno->nombres = $request->input('nombres');
        $alumno->apellidos = $request->input('apellidos');
        $alumno->dni = $request->input('dni');
        $alumno->cuil = $request->input('cuil');
        $alumno->fecha = $request->input('fecha');
        $alumno->email = $request->input('email');
        $alumno->edad = $request->input('edad');
        $alumno->nacionalidad = $request->input('nacionalidad');
        $alumno->domicilio = $request->input('domicilio');
        $alumno->residencia = $request->input('residencia');
        $alumno->telefono = $request->input('telefono');
        $alumno->escolaridad = $request->input('escolaridad');
        $alumno->condicion_s = $request->input('condicion_s');
        $alumno->escuela_s = $request->input('escuela_s');
        $alumno->materias_s = $request->input('materias_s');
        $alumno->conexion = $request->input('conexion');

        $alumno->update();

        return redirect()->route('alumno.editar',['id'=>$alumno->id])->with([
            'message' => 'Los datos han sido editado con éxito!'
        ]);
    }

    public function ver_foto(string $foto){
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
        $data = [
            'alumno' => $alumno
        ];

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pdfs.alumno_ficha',$data);

        return $pdf->download('Ficha '.$alumno->nombres.' '.$alumno->apellidos.'.pdf');
    }
}
