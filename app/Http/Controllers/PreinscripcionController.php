<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreinscripcionExport;
use App\Jobs\PreinscripcionGoogleDriveJob;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Preinscripcion;
use App\Mail\PreEnrolledFormReceived;
use App\Mail\FileErrorForm;
use App\Mail\VerifiedPreEnroll;
use App\Models\MailCheck;
use App\Services\MailService;
use App\Services\PreinscripcionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Serializable;

class PreinscripcionController extends Controller
{

    protected $disk;
    protected $mailService;
    protected $preinscripcionService;

    public function __construct(
        MailService $mailService,
        PreinscripcionService $preinscripcionService
    ) {
        $this->middleware('app.auth', ['only' => ['vista_admin']]);
        $this->middleware('app.roles:admin-areaSocial-regente', ['only' => ['vista_admin', 'vista_all','vista_verificadas','vista_verificadas']]);
        $this->disk = Storage::disk('google');
        $this->mailService = $mailService;
        $this->preinscripcionService = $preinscripcionService;
    }

    public function email_check(Request $request, $timecheck, $carrera_id)
    {
        $mailcheck = $this->mailService->checkEmail($timecheck);

        return redirect()->route('alumno.pre', [
            'id' => $carrera_id,
            'timecheck' => $timecheck
        ]);
    }

    // Vistas
    public function vista_preinscripcion($id, $timecheck = null)
    {
        $checked = null;

        if ($timecheck) {
            $email_check = MailCheck::where([
                'timecheck' => $timecheck,
                'checked' => true
            ])->first();

            $checked = $email_check ?? null;
        }

        $carrera = Carrera::find($id);
        $error = '';

        if($carrera)
        {
            if (!$carrera->preinscripcion_habilitada && !Session::has('preinscripciones')) {
                $carrera = null;
                $error = 'Página deshabilitada';
            }
    
        }else{
            $carrera = null;
            $error = 'Página deshabilitada';
        }
        
        /*
        if (!Auth::user() && !Session::has('admin')) {
           
        }*/

        return view('alumno.pre_enroll', [
            'carrera'   =>  $carrera,
            'error'     =>  $error,
            'checked'   => $checked
        ]);
    }
    public function vista_editar($timecheck, $id)
    {
        $preinscripcion = Preinscripcion::where([
            'id'    =>  $id,
            'timecheck' =>  $timecheck
        ])->first();

        if (Session::has('admin') || Session::has('areaSocial')) {
            $ruta = 'alumno.edit_pre_enroll';
            $datos =  ['preinscripcion'    =>  $preinscripcion];
        } else {
            if ($preinscripcion && $preinscripcion->estado == 'verificado') {
                $ruta = 'error.error';
                $datos = ['mensaje' => 'Tu preinscripción ya fue verificada'];
            } else if (!$preinscripcion) {
                $ruta = 'error.error';
                $datos = ['mensaje' => 'Error en la página'];
            } else {
                $ruta = 'alumno.edit_pre_enroll';
                $datos =  ['preinscripcion'    =>  $preinscripcion];
            }
        }

        return view($ruta, $datos);
    }
    public function vista_inscripto(Request $request,$carrera_id)
    {
        $carrera = Carrera::find($carrera_id);
        $title = "Tu preinscripción ha sido enviada con éxito";
        $content = "Terminados de procesar los datos de tu preinscripción se enviará un comprobante a tu correo electronico, los datos serán verificados
        en el establecimiento y se te informará el resultado.";
        $edit = false;

        return view('alumno.enrolled', [
            'carrera' => $carrera,
            'title' => $title,
            'content' => $content,
            'edit' => $edit
        ]);
    }
    public function vista_editado($timecheck)
    {
        $preinscripcion = Preinscripcion::where([
            'timecheck' => $timecheck
        ])->first();
        $title = "Tu datos han sido editados correctamente";
        $content = "Se ha enviado tu correo electronico un comprobante con los datos nuevos.";
        $edit = true;

        return view('alumno.enrolled', [
            'preinscripcion' => $preinscripcion,
            'title' => $title,
            'content' => $content,
            'edit' => $edit
        ]);
    }
    public function vista_admin($busqueda = null)
    {
        $preinscripciones = [];
        $carreras = [];
        $carreras_id = [];

        if (!empty($busqueda)) {
            $preinscripciones = Preinscripcion::where(function($query) use ($busqueda){
                return $query->where('dni', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('nombres', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('apellidos', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('email', 'LIKE', '%' . $busqueda . '%');
            });

            if (Session::has('coordinador') || Session::has('seccionAlumnos')) {
                foreach (Auth::user()->carreras as $carrera) {
                    array_push($carreras_id,$carrera->id);
                }

                $preinscripciones = $preinscripciones->whereIn('carrera_id',$carreras_id);
            }

            $preinscripciones = $preinscripciones->get();
        } else {
            if (Session::has('coordinador') || Session::has('seccionAlumnos')) {
                $carreras = Auth::user()->carreras;
            } else {
                $carreras = Carrera::orderBy('carrera_id','ASC')->get();
            }
        }


        return view('preinscripcion.admin', [
            'carreras'  =>  $carreras,
            'preinscripciones'   => $preinscripciones
        ]);
    }
    public function vista_all($carrera_id)
    {
        $preinscripciones = Preinscripcion::orderBy('nombres', 'ASC')->where([
            'carrera_id' => $carrera_id,
            'estado'    => 'sin verificar'
        ])->get();

        $carrera = Carrera::find($carrera_id);

        return view('preinscripcion.all', [
            'preinscripciones'  =>  $preinscripciones,
            'carrera'           =>  $carrera
        ]);
    }
    public function vista_detalle(int $id)
    {
        $preinscripcion = Preinscripcion::find($id);

        return view('preinscripcion.detail', [
            'alumno' => $preinscripcion
        ]);
    }
    public function vista_verificadas($id)
    {
        $preinscripciones = Preinscripcion::orderBy('nombres', 'ASC')->where([
            'carrera_id' => $id,
            'estado'    => 'verificado'
        ])->orderBy('updated_at', 'desc')->get();
        $carrera = Carrera::find($id);
        $title = 'Verificados en';

        return view('preinscripcion.verified', [
            'carrera' => $carrera,
            'preinscripciones' => $preinscripciones,
            'title'             => $title
        ]);
    }

    public function vista_sincorregir($id)
    {
        $preinscripciones = Preinscripcion::orderBy('nombres', 'ASC')->where([
            'carrera_id' => $id,
            'estado'    => 'por corregir'
        ])->orderBy('updated_at', 'desc')->get();
        $carrera = Carrera::find($id);
        $title = 'Por corregir de';

        return view('preinscripcion.verified', [
            'carrera' => $carrera,
            'preinscripciones' => $preinscripciones,
            'title'             => $title
        ]);
    }

    public function vista_articulo()
    {
        $preinscripciones = Preinscripcion::where('articulo_septimo',1)->get();

        return view('preinscripcion.article', [
            'preinscripciones' => $preinscripciones
        ]);
    }

    public function vista_eliminadas()
    {
        $preinscripciones = Preinscripcion::withTrashed()->get();

        $preinscripcionesEliminadas = [];
        foreach ($preinscripciones as $preinscripcion) {
            if ($preinscripcion->deleted_at) {
                array_push($preinscripcionesEliminadas, $preinscripcion);
            }
        }

        return view('preinscripcion.eliminadas', [
            'preinscripciones' => $preinscripcionesEliminadas
        ]);
    }

    // Funcionalidades
    public function crear(Request $request, int $carrera_id)
    {
        $validate = $this->validate($request, [
            'nombres'       =>  ['required'],
            'apellidos'     =>  ['required'],
            'dni'           =>  ['required', 'numeric'],
            'cuil'          =>  ['required', 'numeric'],
            'fecha'         =>  ['required'],
            'email'         =>  ['required', 'email'],
            'edad'          =>  ['required', 'numeric'],
            'nacionalidad'  =>  ['required'],
            'domicilio'     =>  ['required'],
            'residencia'    =>  ['required'],
            'telefono'      =>  ['required', 'numeric'],
            'trabajo'       =>  ['required'],
            'condicion_s'   =>  ['required'],
            'escolaridad'   =>  ['required'],
            'escuela_s'     =>  ['required'],
            'materias_s'     =>  ['required'],
            'conexion'      =>  ['required'],
            'dni_archivo_file'   =>  ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'certificado_archivo_file'   =>  ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'comprobante_file'           =>  ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'dni_archivo_2_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'certificado_archivo_2_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'primario_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'ctrabajo_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'curriculum_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'nota_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
        ]);

        $carrera = Carrera::find($carrera_id);

        $exists = Preinscripcion::where([
            'dni' => $request['dni'],
        ])->get();

        foreach ($exists as $exist) {
            if ($exist->carrera->resolucion == $carrera->resolucion) {
                return redirect()->route('alumno.pre', [
                    'id' => $carrera_id
                ])->with([
                    'error_carrera' => 'Ya estas inscripto a la carrera '.$carrera->nombre.' - '.$carrera->sede->nombre
                ]);
            }
        }

        $data = $this->preinscripcionService->guardarArchivosTemporales($request);
        $data['carrera_id'] = $carrera_id;

        
        dispatch(new PreinscripcionGoogleDriveJob($data));

        return redirect()->route('pre.inscripto', [
            'carrera_id' => $carrera->id,
        ]);
    }

    public function editar(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'año'           =>  ['numeric', 'max:3'],
            'nombres'       =>  ['required'],
            'apellidos'     =>  ['required'],
            'dni'           =>  ['required', 'numeric'],
            'cuil'          =>  ['required', 'numeric'],
            'fecha'         =>  ['required'],
            'email'         =>  ['required', 'email'],
            'edad'          =>  ['required', 'numeric'],
            'nacionalidad'  =>  ['required'],
            'domicilio'     =>  ['required'],
            'residencia'    =>  ['required'],
            'telefono'      =>  ['required', 'numeric'],
            'trabajo'       =>  ['required'],
            'condicion_s'   =>  ['required'],
            'escolaridad'   =>  ['required'],
            'escuela_s'     =>  ['required'],
            'materia_s'     =>  ['required'],
            'conexion'      =>  ['required'],
            'dni_archivo_file'   =>  ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'certificado_archivo_file'   =>  ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'comprobante_file'           =>  ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'dni_archivo_2_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'certificado_archivo_2_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'primario_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'ctrabajo_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'curriculum_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'nota_file' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
        ]);

        $preinscripcion = Preinscripcion::find($id);

        $data = $this->preinscripcionService->guardarArchivosTemporales($request);        
        dispatch(new PreinscripcionGoogleDriveJob($data,$preinscripcion));
        

        return redirect()->route('pre.editado', [
            'timecheck' => $preinscripcion->timecheck,
            'id'        => $preinscripcion->id
        ]);
    }

    public function borrar($timecheck, $id)
    {
        $preinscripcion = Preinscripcion::where([
            'id' => $id,
            'timecheck' => $timecheck
        ])->first();

        $preinscripciones = Preinscripcion::where('dni', $preinscripcion->dni)->count();

        if ($preinscripciones == 1) {
            $dir = '/';
            $recursive = false; // Get subdirectories also?
            $contents = collect($this->disk->listContents($dir, $recursive));

            $directory = $contents
                ->where('type', '=', 'dir')
                ->where('filename', '=', $preinscripcion->dni)
                ->first();

            $this->disk->deleteDirectory($directory['path']);
        }

        if (Auth::user()) {
            $preinscripcion->responsable_delete = Auth::user()->nombre . ' ' . Auth::user()->apellido;
        } else {
            $preinscripcion->responsable_delete = $preinscripcion->nombres . ' ' . $preinscripcion->apellidos;
        }

        $preinscripcion->update();

        $preinscripcion->delete();

        $title = "Tu preinscripción ha sido eliminada";
        $content = "Se ha enviado tu correo electrónico un comprobante, podrás volver a inscribirte hasta la fecha límite establecida.";
        $delete = true;

        return view('alumno.enrolled', [
            'title' => $title,
            'content' => $content,
            'delete' => $delete
        ]);
    }

    public function cambiar_estado(int $id)
    {
        $preinscripcion = Preinscripcion::find($id);

        if ($preinscripcion->estado != 'verificado') {
            $preinscripcion->estado = 'verificado';
            Mail::to($preinscripcion->email)->send(new VerifiedPreEnroll($preinscripcion));
        } else {
            $preinscripcion->estado = 'sin verificar';
        }

        $preinscripcion->update();

        return redirect()->route('pre.all', [
            'id'    =>  $preinscripcion->carrera_id
        ]);
    }

    public function descargar_excel($carrera_id)
    {
        $carrera = Carrera::find($carrera_id);
        return Excel::download(new PreinscripcionExport($carrera_id), 'Preinscripción ' . $carrera->nombre . '.xlsx');
    }

    public function descargar_verificados()
    {
        return Excel::download(new PreinscripcionExport(1, true), 'Preinscripciones verificadas ' . date("d-m-y") . ".xlsx");
    }

    public function email_archivo_error(Request $request, $id)
    {
        $datos = $request->all();

        unset($datos['_token']);
        $preinscripcion = Preinscripcion::find($id);
        $preinscripcion->estado = 'por corregir';
        $preinscripcion->update();

        Mail::to($preinscripcion->email)->send(new FileErrorForm($preinscripcion, $datos));

        return redirect()->route('pre.all', [
            'id' => $preinscripcion->carrera_id
        ]);
    }
}
