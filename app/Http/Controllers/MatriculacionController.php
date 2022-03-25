<?php

namespace App\Http\Controllers;

use App\Mail\CheckEmail;
use App\Mail\MatriculacionSuccessEmail;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Carrera;
use App\Models\MailCheck;
use App\Models\Proceso;
use App\Services\ProcesoService as ServicesProcesoService;
use Illuminate\Http\Request;
use ProcesoService;
use Illuminate\Support\Facades\Mail;

class MatriculacionController extends Controller
{
    protected $procesoService;

    public function __construct(
        ServicesProcesoService $procesoService
    ) {
        $this->procesoService = $procesoService;
        $this->middleware('app.auth',['only'=>['edit','update']]);
        $this->middleware('app.roles:admin-coordinador',['only'=>['edit','update']]);
    }

    public function create($carrera_id, $year, $timecheck = false)
    {
        $carrera = Carrera::find($carrera_id);
        $email_checked = $timecheck;

        return view('matriculacion.create', [
            'carrera' => $carrera,
            'año' => $year,
            'email_checked' => $email_checked
        ]);
    }

    public function edit($alumno_id,$carrera_id)
    {
        $alumno = Alumno::find($alumno_id);
        $carrera = Carrera::find($carrera_id);
        $alumno_carrera = AlumnoCarrera::where([
            'alumno_id' => $alumno_id,
            'carrera_id'=> $carrera_id
        ])->first();

        return view('matriculacion.edit',[
            'matriculacion' => $alumno,
            'carrera' => $carrera,
            'año'   => $alumno_carrera->año
        ]);
    }

    public function store(Request $request, $carrera_id, $año)
    {
        $validate = $this->validate($request, [
            'nombres'               => ['required'],
            'apellidos'             => ['required'],
            'dni'                   => ['required'],
            'edad'                  => ['required'],
            'email'                 => ['required', 'email'],
            'telefono'              => ['required'],
            'provincia'             => ['required'],
            'localidad'             => ['required'],
            'discapacidad_mental'   => ['required'],
            'discapacidad_visual'   => ['required'],
            'discapacidad_motriz'   => ['required'],
            'acompañamiento_motriz' => ['required'],
            'discapacidad_intelectual' => ['required'],
            'codigo_postal' => ['required'],
            'matriculacion' => ['required'],
            'regularidad' => ['required'],
            'privacidad' => ['required'],
            'poblacion_indigena' => ['required']
        ]);

        $mail_check = MailCheck::where([
            'email'=>$request['email'],
            'checked' => true
        ])->first();

        if(!$mail_check)
        {
            return redirect()->route('matriculacion.create',[
                'id' => $carrera_id,
                'year' => $año,
                'timecheck' => false
            ])->with([
                'email_error' => 'El email utilizado, no esta verificado, por favor verifica el email antes de utilizarlo.'
            ]);
        }

        $request['año'] = $año;

        $alumno = Alumno::where([
            'dni' => $request['dni'],
            'cuil' => $request['cuil']
        ])->first();

        if (!$alumno) {

            $alumno = Alumno::create($request->all());
        }

        if ($alumno->hasCarrera($carrera_id)) 
        {
            $mensaje = "Ya estas inscripto a esta carrera.";
        } 
        else 
        {
            $carrera = Carrera::find($carrera_id);


            AlumnoCarrera::create([
                'alumno_id' => $alumno->id,
                'carrera_id' => $carrera->id,
                'año'   => $año
            ]);

            if(isset($request['materias'])){
                $this->procesoService->inscribir($alumno->id, $request['materias']);
            }

            Mail::to($request['email'])->send(new MatriculacionSuccessEmail($alumno,$carrera));


            $mensaje = "Felicidades te has matriculado correctamente a ".$carrera->nombre." ".$carrera->sede->nombre;
        }


        return view('matriculacion.card_finalizada', [
            'alumno' => $alumno,
            'mensaje' => $mensaje
        ]);
    }

    public function update(Request $request,$id)
    {
        $validate = $this->validate($request, [
            'nombres'               => ['required'],
            'apellidos'             => ['required'],
            'dni'                   => ['required'],
            'email'                 => ['required', 'email'],
            'discapacidad_mental'   => ['required'],
            'discapacidad_visual'   => ['required'],
            'discapacidad_motriz'   => ['required'],
            'acompañamiento_motriz' => ['required'],
            'discapacidad_intelectual' => ['required'],
            'matriculacion' => ['required'],
            'telefono' => ['required','numeric'],
            'telefono_fijo' => ['numeric']
        ]);

        $alumno = Alumno::find($id);

        $alumno->update($request->all());

        return redirect()->route('alumno.detalle',[
            'id' => $alumno->id
        ])->with([
            'mensaje_editado' => 'Datos editados correctamente'
        ]);
    }

    public function delete($id,$carrera_id){
        $alumno = Alumno::find($id);
        $carrera = Carrera::find($id);

        $procesos = Proceso::where('alumno_id',$alumno->id)->get();

        foreach($procesos as $proceso)
        {
            if($proceso->materia->carrera_id == $carrera->id)
            {
                $proceso->delete();
            }
        }

        AlumnoCarrera::where([
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera->id
        ])->delete();
        
        $alumno->delete();

        return redirect('alumno.alumnos',[
            'carrera' => $carrera
        ])->with([
            'alumno_deleted' => 'Alumno eliminado, se le ha enviado un correo con una notificación'
        ]);

    }


    public function send_email(Request $request,$carrera_id,$año)
    {
        $validate = $this->validate($request,[
            'email' => ['required','email']
        ]);

        $mail_check = MailCheck::where('email',$request['email'])->first();

        if($mail_check && $mail_check->checked)
        {
            return redirect()->route('matriculacion.create', [
                'id' => $carrera_id,
                'year' => $año,
                'timecheck' => true
            ]);
        }
        elseif ($mail_check && !$mail_check->checked)
        {
            Mail::to($request['email'])->send(new CheckEmail($mail_check,$carrera_id,$año));
        }
        else
        {
            $request['timecheck'] = time();
            $mail_check = MailCheck::create($request->all());
    
            Mail::to($request['email'])->send(new CheckEmail($mail_check,$carrera_id,$año));
        }

        return view('matriculacion.card_email_check');
    }

    public function email_check($timecheck,$carrera_id,$año)
    {
        $mail_check = MailCheck::where('timecheck',$timecheck)->first();

        $mail_check->checked = true;

        $mail_check->update();

        return redirect()->route('matriculacion.create',[
            'id' => $carrera_id,
            'year' => $año,
            'timecheck' => $timecheck
        ]);
    }
}
