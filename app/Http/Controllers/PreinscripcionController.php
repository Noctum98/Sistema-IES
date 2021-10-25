<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreinscripcionExport;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Preinscripcion;
use App\Mail\PreEnrolledFormReceived;
use App\Mail\FileErrorForm;
use App\Mail\VerifiedPreEnroll;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class PreinscripcionController extends Controller
{
    public function __construct(){
        $this->middleware('app.auth',['only' => ['vista_admin']]);
    }
    // Vistas
    public function vista_preinscripcion($id){
        $carrera = Carrera::find($id);
        $error = '';
        
        
        if(($carrera->estado == 1 || $carrera->vacunas == 'todas') && !Auth::user()){
            $carrera = null;
            $error = 'Página deshabilitada';
        }
        

        return view('alumno.pre_enroll',[
            'carrera'   =>  $carrera,
            'error'     =>  $error
        ]);
    }
    public function vista_editar($timecheck,$id){
        $preinscripcion = Preinscripcion::where([
            'id'    =>  $id,
            'timecheck' =>  $timecheck
        ])->first();
        
        return view('alumno.edit_pre_enroll',[
            'preinscripcion'    =>  $preinscripcion
        ]);
    }
    public function vista_inscripto($timecheck,int $id){
        $preinscripcion = Preinscripcion::where([
            'timecheck'=>$timecheck
        ])->first();
        $title = "Tu preinscripción ha sido enviada con éxito";
        $content = "Se ha enviado un comprobante a tu correo electronico.";
        $edit = false;

        return view('alumno.enrolled',[
            'preinscripcion' => $preinscripcion,
            'title' => $title,
            'content' => $content,
            'edit' => $edit
        ]);
    }
    public function vista_editado($timecheck,int $id){
        $preinscripcion = Preinscripcion::where([
            'timecheck'=>$timecheck
        ])->first();
        $title = "Tu datos han sido editados correctamente";
        $content = "Se ha enviado tu correo electronico un comprobante con los datos nuevos.";
        $edit = true;

        return view('alumno.enrolled',[
            'preinscripcion' => $preinscripcion,
            'title' => $title,
            'content' => $content,
            'edit' => $edit
        ]);
    }
    public function vista_admin($busqueda = null){
        $preinscripciones = [];
        $carreras = [];
        if(Auth::user()->rol == 'rol_admin' || Auth::user()->rol == 'rol_main'){
            if(!empty($busqueda)){
            $preinscripciones = Preinscripcion::where('dni','LIKE','%'.$busqueda.'%')
                            ->orWhere('nombres','LIKE','%'.$busqueda.'%')
                            ->orWhere('apellidos','LIKE','%'.$busqueda.'%')
                            ->orWhere('email','LIKE','%'.$busqueda.'%')
                            ->get();
            }else{
                $carreras = Carrera::all();
            }
        }else{
            $carreras = Carrera::where('sede_id',Auth::user()->sede_id)->get();
        }
        

        return view('preinscripcion.admin',[
            'carreras'  =>  $carreras,
            'preinscripciones'   => $preinscripciones
        ]);
    }
    public function vista_all($carrera_id){
        $preinscripciones = Preinscripcion::orderBy('nombres','ASC')->where([
            'carrera_id'=>$carrera_id,
            'estado'    =>'sin verificar'
        ])->get();
        $carrera = Carrera::find($carrera_id);

        return view('preinscripcion.all',[
            'preinscripciones'  =>  $preinscripciones,
            'carrera'           =>  $carrera
        ]);
    }
    public function vista_detalle(int $id){
        $preinscripcion = Preinscripcion::find($id);

        return view('preinscripcion.detail',[
            'alumno'=>$preinscripcion
        ]);
    }
    public function vista_verificadas($id){
        $preinscripciones = Preinscripcion::orderBy('nombres','ASC')->where([
            'carrera_id'=>$id,
            'estado'    =>'verificado'
        ])->orderBy('updated_at','desc')->get();
        $carrera = Carrera::find($id);
        $title = 'Verificados en';
        
        return view('preinscripcion.verified',[
            'carrera'=>$carrera,
            'preinscripciones' =>$preinscripciones,
            'title'             =>$title
        ]);
    }
    public function vista_sincorregir($id){
        $preinscripciones = Preinscripcion::orderBy('nombres','ASC')->where([
            'carrera_id'=>$id,
            'estado'    =>'por corregir'
        ])->orderBy('updated_at','desc')->get();
        $carrera = Carrera::find($id);
        $title = 'Por corregir de';
        
        return view('preinscripcion.verified',[
            'carrera'=>$carrera,
            'preinscripciones' =>$preinscripciones,
            'title'             =>$title
        ]);
    }
    public function vista_articulo(){
        $preinscripciones = Preinscripcion::whereNotNUll('curriculum')->get();
        
        return view('preinscripcion.article',[
            'preinscripciones' => $preinscripciones
        ]);
    }

    // Funcionalidades

    public function crear(Request $request,int $carrera_id){
        $carrera = Carrera::find($carrera_id);

        $validate = $this->validate($request,[
            'nombres'       =>  ['required'],
            'apellidos'     =>  ['required'],
            'dni'           =>  ['required','numeric'],
            'cuil'          =>  ['required','numeric'],
            'fecha'         =>  ['required'],
            'email'         =>  ['required','email','confirmed'],
            'edad'          =>  ['required','numeric'],
            'nacionalidad'  =>  ['required'],
            'domicilio'     =>  ['required'],
            'residencia'    =>  ['required'],
            'telefono'      =>  ['required','numeric'],
            'trabajo'       =>  ['required'],
            'condicion_s'   =>  ['required'],
            'escolaridad'   =>  ['required'],
            'escuela_s'     =>  ['required'],
            'materia_s'     =>  ['required'],
            'conexion'      =>  ['required'],
            'dni_archivo'   =>  ['required','mimes:jpg,jpeg,png,pdf'],
            'certificado_archivo'   =>  ['required','mimes:jpg,jpeg,png,pdf'],
            'comprobante'           =>  ['required','mimes:jpg,jpeg,png,pdf'],
        ]);

        $exists = Preinscripcion::where([
            'dni'=>$request->input('dni'),
        ])->get();

        foreach($exists as $pre){
            if($pre->carrera->nombre == $carrera->nombre){
                return redirect()->route('alumno.pre',[
                    'id'=>$carrera_id
                ])->with([
                    'error_carrera' => 'Ya estas inscripto en esta carrera.'
                ]);
            }
        }
        

        $dni_archivo = $request->file('dni_archivo');
        $dni_archivo2 = $request->file('dni_archivo_2');
        $comprobante = $request->file('comprobante');
        $certificado_archivo = $request->file('certificado_archivo');
        $certificado_archivo2 = $request->file('certificado_archivo_2');
        $primario = $request->file('primario');
        $curriculum = $request->file('curriculum');
        $ctrabajo = $request->file('ctrabajo');
        $nota = $request->file('nota');

        $preinscripcion = new Preinscripcion();

        if($dni_archivo){
            $dni_nombre = time().$dni_archivo->getClientOriginalName();

            Storage::disk('alumno_dni')->put($dni_nombre,File::get($dni_archivo));
            $preinscripcion->dni_archivo = $dni_nombre;
        }
        if($dni_archivo2){
            $dni_nombre2 = time().$dni_archivo2->getClientOriginalName();

            Storage::disk('alumno_dni')->put($dni_nombre2,File::get($dni_archivo2));
            $preinscripcion->dni_archivo_2 = $dni_nombre2;
        }
         if($comprobante){
            $comprobante_nombre = time().$comprobante->getClientOriginalName();

            Storage::disk('comprobante')->put($comprobante_nombre,File::get($comprobante));
            $preinscripcion->comprobante = $comprobante_nombre;
        }
        if($certificado_archivo){
            $certificado_nombre = time().$certificado_archivo->getClientOriginalName();

            Storage::disk('alumno_certificado')->put($certificado_nombre,File::get($certificado_archivo));
            $preinscripcion->certificado_archivo = $certificado_nombre;
        }
        if($certificado_archivo2){
            $certificado_nombre2 = time().$certificado_archivo2->getClientOriginalName();

            Storage::disk('alumno_certificado')->put($certificado_nombre2,File::get($certificado_archivo2));
            $preinscripcion->certificado_archivo_2 = $certificado_nombre2;
        }
        if($primario){
            $primario_nombre = time().$primario->getClientOriginalName();

            Storage::disk('alumno_primario')->put($primario_nombre,File::get($primario));
            $preinscripcion->primario = $primario_nombre;
        }
        if($curriculum){
            $curriculum_nombre = time().$curriculum->getClientOriginalName();

            Storage::disk('alumno_curriculum')->put($curriculum_nombre,File::get($curriculum));
            $preinscripcion->curriculum = $curriculum_nombre;
        }
        if($ctrabajo){
            $ctrabajo_nombre = time().$ctrabajo->getClientOriginalName();

            Storage::disk('alumno_ctrabajo')->put($ctrabajo_nombre,File::get($ctrabajo));
            $preinscripcion->ctrabajo = $ctrabajo_nombre;
        }
        if($nota){
            $nota_nombre = time().$nota->getClientOriginalName();

            Storage::disk('alumno_nota')->put($nota_nombre,File::get($nota));
            $preinscripcion->nota = $nota_nombre;
        }


        $preinscripcion->carrera_id = $carrera_id;
        $preinscripcion->nombres = $request->input('nombres');
        $preinscripcion->apellidos = $request->input('apellidos');
        $preinscripcion->dni = $request->input('dni');
        $preinscripcion->cuil = $request->input('cuil');
        $preinscripcion->fecha = $request->input('fecha');
        $preinscripcion->email = $request->input('email');
        $preinscripcion->edad = $request->input('edad');
        $preinscripcion->nacionalidad = $request->input('nacionalidad');
        $preinscripcion->domicilio = $request->input('domicilio');
        $preinscripcion->residencia = $request->input('residencia');
        $preinscripcion->telefono = $request->input('telefono');
        $preinscripcion->escolaridad = $request->input('escolaridad');
        $preinscripcion->condicion_s = $request->input('condicion_s');
        $preinscripcion->escuela_s = $request->input('escuela_s');
        $preinscripcion->materias_s = $request->input('materia_s');
        $preinscripcion->conexion = $request->input('conexion');
        $preinscripcion->trabajo = $request->input('trabajo');
        $preinscripcion->estado = 'sin verificar';
        $preinscripcion->timecheck = time();
        $preinscripcion->save();

        Mail::to($preinscripcion->email)->send(new PreEnrolledFormReceived($preinscripcion));

        return redirect()->route('pre.inscripto',[
            'timecheck' => $preinscripcion->timecheck,
            'id'        => $preinscripcion->id
        ]);
        
    }
    public function editar(Request $request,$id){
        $preinscripcion = Preinscripcion::find($id);

        $validate = $this->validate($request,[
            'año'           =>  ['numeric','max:3'],
            'nombres'       =>  ['required'],
            'apellidos'     =>  ['required'],
            'dni'           =>  ['required','numeric'],
            'cuil'          =>  ['required','numeric'],
            'fecha'         =>  ['required'],
            'email'         =>  ['required','email'],
            'edad'          =>  ['required','numeric'],
            'nacionalidad'  =>  ['required'],
            'domicilio'     =>  ['required'],
            'residencia'    =>  ['required'],
            'telefono'      =>  ['required','numeric'],
            'trabajo'       =>  ['required'],
            'condicion_s'   =>  ['required'],
            'escolaridad'   =>  ['required'],
            'escuela_s'     =>  ['required'],
            'materia_s'     =>  ['required'],
            'conexion'      =>  ['required'],
            'dni_archivo'   =>  ['mimes:jpg,jpeg,png,pdf'],
            'certificado_archivo'   =>  ['mimes:jpg,jpeg,png,pdf'],
            'comprobante'           =>  ['mimes:jpg,jpeg,png,pdf'],
        ]);

        $preinscripcion = Preinscripcion::find($id);
        $dni_archivo_2 = $request->file('dni_archivo_2');
        $certificado_archivo_2 = $request->file('certificado_archivo_2');
        $dni_archivo = $request->file('dni_archivo');
        $partida_archivo = $request->file('partida_archivo');
        $imagen_archivo = $request->file('imagen');
        $titulo_archivo = $request->file('titulo_archivo');
        $certificado_archivo = $request->file('certificado_archivo');
        $psicofisico_archivo = $request->file('psicofisico');
        $primario = $request->file('primario');
        $curriculum = $request->file('curriculum');
        $ctrabajo = $request->file('ctrabajo');
        $nota = $request->file('nota');
        $comprobante = $request->file('comprobante');

        

        if($dni_archivo){
            $dni_nombre = time().$dni_archivo->getClientOriginalName();

            Storage::disk('alumno_dni')->delete($preinscripcion->dni_archivo);
            Storage::disk('alumno_dni')->put($dni_nombre,File::get($dni_archivo));
            $preinscripcion->dni_archivo = $dni_nombre;
        }
        if($dni_archivo_2){
            $dni_nombre2 = time().$dni_archivo_2->getClientOriginalName();

            Storage::disk('alumno_dni')->delete($preinscripcion->dni_archivo_2);
            Storage::disk('alumno_dni')->put($dni_nombre2,File::get($dni_archivo_2));
            $preinscripcion->dni_archivo_2 = $dni_nombre2;
        }
         if($comprobante){
            $comprobante_nombre = time().$comprobante->getClientOriginalName();

            Storage::disk('comprobante')->delete($preinscripcion->comprobante);
            Storage::disk('comprobante')->put($comprobante_nombre,File::get($comprobante));
            $preinscripcion->comprobante = $comprobante_nombre;
        }


        if($partida_archivo){
            $partida_nombre = time().$partida_archivo->getClientOriginalName();

            Storage::disk('alumno_partida')->delete($preinscripcion->partida_archivo);
            Storage::disk('alumno_partida')->put($partida_nombre,File::get($partida_archivo));
            $preinscripcion->partida_archivo = $partida_nombre;
        }

        if($titulo_archivo){
            $titulo_nombre = time().$titulo_archivo->getClientOriginalName();

            Storage::disk('alumno_titulo')->delete($preinscripcion->titulo_archivo);
            Storage::disk('alumno_titulo')->put($titulo_nombre,File::get($titulo_archivo));
            $preinscripcion->titulo_archivo = $titulo_nombre;
        }

        if($certificado_archivo){
            $certificado_nombre = time().$certificado_archivo->getClientOriginalName();

            Storage::disk('alumno_certificado')->delete($preinscripcion->certificado_archivo);
            Storage::disk('alumno_certificado')->put($certificado_nombre,File::get($certificado_archivo));
            $preinscripcion->certificado_archivo = $certificado_nombre;
        }
           if($certificado_archivo_2){
            $certificado_nombre2 = time().$certificado_archivo_2->getClientOriginalName();

            Storage::disk('alumno_certificado')->delete($preinscripcion->certificado_archivo_2);
            Storage::disk('alumno_certificado')->put($certificado_nombre2,File::get($certificado_archivo_2));
            $preinscripcion->certificado_archivo_2 = $certificado_nombre2;
        }

        if($psicofisico_archivo){
            $psicofisico_nombre = time().$psicofisico_archivo->getClientOriginalName();

            Storage::disk('alumno_psicofisico')->delete($preinscripcion->psicofisico_archivo);
            Storage::disk('alumno_psicofisico')->put($psicofisico_nombre,File::get($psicofisico_archivo));
            $preinscripcion->psicofisico_archivo = $psicofisico_nombre;
        }
        if($primario){
            $primario_nombre = time().$primario->getClientOriginalName();

            Storage::disk('alumno_primario')->delete($preinscripcion->primario);
            Storage::disk('alumno_primario')->put($primario_nombre,File::get($primario));
            $preinscripcion->primario = $primario_nombre;
        }
        if($curriculum){
            $curriculum_nombre = time().$curriculum->getClientOriginalName();

            Storage::disk('alumno_curriculum')->delete($preinscripcion->curriculum);
            Storage::disk('alumno_curriculum')->put($curriculum_nombre,File::get($curriculum));
            $preinscripcion->curriculum = $curriculum_nombre;
        }
        if($ctrabajo){
            $ctrabajo_nombre = time().$ctrabajo->getClientOriginalName();

            Storage::disk('alumno_ctrabajo')->delete($preinscripcion->ctrabajo);
            Storage::disk('alumno_ctrabajo')->put($ctrabajo_nombre,File::get($ctrabajo));
            $preinscripcion->ctrabajo = $ctrabajo_nombre;
        }
        if($nota){
            $nota_nombre = time().$nota->getClientOriginalName();

            Storage::disk('alumno_nota')->delete($preinscripcion->nota);
            Storage::disk('alumno_nota')->put($nota_nombre,File::get($nota));
            $preinscripcion->nota = $nota_nombre;
        }

        $preinscripcion->nombres = $request->input('nombres');
        $preinscripcion->apellidos = $request->input('apellidos');
        $preinscripcion->dni = $request->input('dni');
        $preinscripcion->edad = $request->input('edad');
        $preinscripcion->email = $request->input('email');
        $preinscripcion->domicilio = $request->input('domicilio');
        $preinscripcion->residencia = $request->input('residencia');
        $preinscripcion->telefono = $request->input('telefono');
        $preinscripcion->escolaridad = $request->input('escolaridad');
        $preinscripcion->escuela_s = $request->input('escuela_s');
        $preinscripcion->materias_s = $request->input('materia_s');
        $preinscripcion->trabajo = $request->input('trabajo');
        $preinscripcion->estado = 'sin verificar';
        $preinscripcion->update();

        Mail::to($preinscripcion->email)->send(new PreEnrolledFormReceived($preinscripcion));

        return redirect()->route('pre.editado',[
            'timecheck' => $preinscripcion->timecheck,
            'id'        => $preinscripcion->id
        ]);
        
    }
    public function borrar($timecheck,$id){
        $preinscripcion = Preinscripcion::where([
            'id'=> $id,
            'timecheck'=>$timecheck
        ])->first();
        
        
        if($preinscripcion->dni_archivo){
            Storage::disk('alumno_dni')->delete($preinscripcion->dni_archivo);
        }
        if($preinscripcion->dni_archivo_2){
            Storage::disk('alumno_dni')->delete($preinscripcion->dni_archivo_2);
        }
        if($preinscripcion->comprobante){
            Storage::disk('comprobante')->delete($preinscripcion->comprobante);
        }
        if($preinscripcion->certificado_archivo){
            Storage::disk('alumno_certificado')->delete($preinscripcion->certificado_archivo);
        }
        if($preinscripcion->certificado_archivo_2){
            Storage::disk('alumno_certificado')->delete($preinscripcion->certificado_archivo_2);
        }
        if($preinscripcion->primario){
            Storage::disk('alumno_primario')->delete($preinscripcion->primario);
        }
        if($preinscripcion->curriculum){
            Storage::disk('alumno_curriculum')->delete($preinscripcion->curriculum);
        }
        if($preinscripcion->ctrabajo){
            Storage::disk('alumno_ctrabajo')->delete($preinscripcion->ctrabajo);
        }
        if($preinscripcion->nota){
            Storage::disk('alumno_nota')->delete($preinscripcion->nota);
        }
        
        $preinscripcion->delete();
        
        $title = "Tu preinscripción ha sido eliminada";
        $content = "Se ha enviado tu correo electronico un comprobante, podrás volver a inscribirte hasta la fecha límite establecida.";
        $delete = true;

        return view('alumno.enrolled',[
            'title' => $title,
            'content' => $content,
            'delete' => $delete
        ]);
    }
    public function cambiar_estado(int $id){
        $preinscripcion = Preinscripcion::find($id);

        if($preinscripcion->estado != 'verificado'){
            $preinscripcion->estado = 'verificado';
            Mail::to($preinscripcion->email)->send(new VerifiedPreEnroll($preinscripcion));
        }else{
            $preinscripcion->estado = 'sin verificar';
        }
        
        $preinscripcion->update();

        return redirect()->route('pre.all',[
            'id'    =>  $preinscripcion->carrera_id
        ]);   
    }
    public function descargar_excel($carrera_id){
        $carrera = Carrera::find($carrera_id);
        return Excel::download(new PreinscripcionExport($carrera_id), 'Preinscripción '.$carrera->nombre.'.xlsx');
    }
    public function descargar_verificados(){
        return Excel::download(new PreinscripcionExport(1,true),'Preinscripciones verificadas '. date("d-m-y").".xlsx");
    }
    public function email_archivo_error(Request $request,$id){
        $datos = $request->all();

        unset($datos['_token']);
        $preinscripcion = Preinscripcion::find($id);
        $preinscripcion->estado = 'por corregir';
        $preinscripcion->update();

        Mail::to($preinscripcion->email)->send(new FileErrorForm($preinscripcion,$datos));

        return redirect()->route('pre.all',[
            'id' => $preinscripcion->carrera_id
        ]);
    }
    
}
