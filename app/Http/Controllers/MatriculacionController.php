<?php

namespace App\Http\Controllers;

use App\Mail\CheckEmail;
use App\Mail\MatriculacionDeleted;
use App\Mail\MatriculacionSuccessEmail;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Carrera;
use App\Models\MailCheck;
use App\Models\Proceso;
use App\Services\ProcesoService as ServicesProcesoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ProcesoService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class MatriculacionController extends Controller
{
    protected $procesoService;

    public function __construct(
        ServicesProcesoService $procesoService
    ) {
        $this->procesoService = $procesoService;
        // $this->middleware('app.auth',['only'=>['edit','update']]);
        // $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente',['only'=>['edit','update']]);
    }

    public function create($carrera_id, $year, $timecheck = false)
    {
        $carrera = Carrera::find($carrera_id);
        $email_checked = $timecheck;

        /*
        $mensaje = "Página deshabilitada";


        if($carrera->id != 17)
        {
            return view('error.disabled_time',[
                'mensaje' => $mensaje
            ]);
        }
        */
        return view('matriculacion.create', [
            'carrera' => $carrera,
            'año' => $year,
            'email_checked' => $email_checked
        ]);
    }

    public function edit($alumno_id, $carrera_id, $año = null)
    {
        $alumno = Alumno::find($alumno_id);
        $carrera = Carrera::find($carrera_id);

        if (!$año) {
            $alumno_carrera = AlumnoCarrera::where([
                'alumno_id' => $alumno_id,
                'carrera_id' => $carrera_id
            ])->first();

            $año = $alumno_carrera->año;
        }


        return view('matriculacion.edit', [
            'matriculacion' => $alumno,
            'carrera' => $carrera,
            'año'     => $año
        ]);
    }

    public function store(Request $request, $carrera_id, $año)
    {
        $validate = $this->validate($request, [
            'nombres'               => ['required'],
            'apellidos'             => ['required'],
            'dni'                   => ['required'],
            'edad'                  => ['required', 'numeric'],
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
            'email' => $request['email'],
            'checked' => true
        ])->first();

        if (!$mail_check) {
            return redirect()->route('matriculacion.create', [
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

        if ($alumno->hasCarrera($carrera_id)) {
            $mensaje = "Ya estas inscripto a esta carrera.";
        } else {
            $carrera = Carrera::find($carrera_id);


            AlumnoCarrera::create([
                'alumno_id' => $alumno->id,
                'carrera_id' => $carrera->id,
                'año'   => $año
            ]);

            if (isset($request['materias'])) {
                $this->procesoService->inscribir($alumno->id, $request['materias']);
            }

            Mail::to($request['email'])->send(new MatriculacionSuccessEmail($alumno,$carrera));


            $mensaje = "Felicidades te has matriculado correctamente a " . $carrera->nombre . " " . $carrera->sede->nombre;
        }


        return view('matriculacion.card_finalizada', [
            'alumno' => $alumno,
            'mensaje' => $mensaje
        ]);
    }

    public function update(Request $request, $id, $carrera_id = null, $año = null)
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
            'telefono' => ['required', 'numeric'],
        ]);

        $alumno = Alumno::find($id);

        $alumno->update($request->all());

        return redirect()->route('matriculacion.edit', [
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera_id,
            'year'      => $año
        ])->with([
            'mensaje_editado' => 'Datos editados correctamente'
        ]);
    }

    public function delete($id, $carrera_id, $año = null)
    {
        $alumno = Alumno::find($id);
        $carrera = Carrera::find($carrera_id);

        $procesos = Proceso::where('alumno_id', $alumno->id)->get();

        foreach ($procesos as $proceso) {
            if ($proceso->materia->carrera_id == $carrera->id) {
                $proceso->delete();
            }
        }

        Mail::to($alumno->email)->send(new MatriculacionDeleted($alumno,$carrera));

        AlumnoCarrera::where([
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera->id
        ])->delete();

        // Log::info($alumno->carreras);
        if (!$alumno->carreras || count($alumno->carreras) == 0) {

            $alumno->delete();

            if (!Auth::user()) 
            {
                return redirect()->route('matriculacion.create', [
                    'id' => $carrera->id,
                    'year' => $año
                ])->with(['alumno_deleted' => 'Matriculación eliminada']);
            }

        } 
        elseif (count($alumno->carreras) > 0 && !Auth::user()) 
        {
            return redirect()->route('matriculacion.edit', [
                'alumno_id' => $alumno->id,
                'carrera_id' => $carrera_id,
                'year'      => $año
            ])->with(['alumno_deleted' => 'Matriculación eliminada']);
        }

        return redirect()->route('alumno.carrera', [
            'carrera_id' => $carrera_id
        ])->with([
            'alumno_deleted' => 'Alumno eliminado, se le ha enviado un correo con una notificación'
        ]);
    }


    public function send_email(Request $request, $carrera_id, $año)
    {
        $validate = $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $mail_check = MailCheck::where('email', $request['email'])->first();

        if ($mail_check && $mail_check->checked) {
            $alumno = Alumno::where('email', $mail_check->email)->first();

            if ($alumno) {
                return redirect()->route('matriculacion.edit', [
                    'carrera_id' => $carrera_id,
                    'alumno_id'  => $alumno->id,
                    'year'        => $año
                ]);
            } else {
                return redirect()->route('matriculacion.create', [
                    'id' => $carrera_id,
                    'year' => $año,
                    'timecheck' => true
                ]);
            }
        } elseif ($mail_check && !$mail_check->checked) {
            Mail::to($request['email'])->send(new CheckEmail($mail_check, $carrera_id, $año));
        } else {
            $request['timecheck'] = time();
            $mail_check = MailCheck::create($request->all());

            Mail::to($request['email'])->send(new CheckEmail($mail_check, $carrera_id, $año));
        }

        return view('matriculacion.card_email_check');
    }

    public function email_check($timecheck, $carrera_id, $año)
    {
        $mail_check = MailCheck::where('timecheck', $timecheck)->first();

        $mail_check->checked = true;

        $mail_check->update();

        return redirect()->route('matriculacion.create', [
            'id' => $carrera_id,
            'year' => $año,
            'timecheck' => $timecheck
        ]);
    }
}
