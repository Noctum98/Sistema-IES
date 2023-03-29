<?php

namespace App\Http\Controllers;

use App\Mail\CheckEmail;
use App\Mail\MatriculacionDeleted;
use App\Mail\MatriculacionSuccessEmail;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\Carrera;
use App\Models\MailCheck;
use App\Models\Proceso;
use App\Models\ProcesoCalificacion;
use App\Models\User;
use App\Services\MailService;
use App\Services\ProcesoService as ServicesProcesoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ProcesoService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MatriculacionController extends Controller
{
    protected $procesoService;
    protected $mailService;

    public function __construct(
        ServicesProcesoService $procesoService,
        MailService $mailService
    ) {
        $this->procesoService = $procesoService;
        $this->mailService = $mailService;
    }

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;

        $carreras = Carrera::whereHas('alumnos', function ($query) use ($user_id) {
            $query->where('alumnos.user_id', $user_id);
        })
            ->with(['alumnos' => function ($query) use ($user_id) {
                $query->where('alumnos.user_id', $user_id);
            }, 'sede'])
            ->where('matriculacion_habilitada', true)->get();


        return view('matriculacion.index', ['carreras' => $carreras]);
    }

    public function create($carrera_id, $year, $timecheck = false)
    {
        $carrera = Carrera::find($carrera_id);
        $email_checked = $timecheck;
        $check_year = false;

        if ($year == 2 || $year == 3) {
            if (Auth::user()) {
                $check_year = true;
            }
        } else {
            $check_year = true;
        }

        if ($check_year) {
            if ($carrera->matriculacion_habilitada) {
                return view('matriculacion.create', [
                    'carrera' => $carrera,
                    'año' => $year,
                    'email_checked' => $email_checked
                ]);
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }

    public function edit($alumno_id, $carrera_id, $año = null)
    {
        $alumno = Alumno::find($alumno_id);
        $carrera = Carrera::find($carrera_id);


        if (!$alumno->aprobado || !Session::has('alumno')) {
            if (!$año) {
                $alumno_carrera = AlumnoCarrera::where([
                    'alumno_id' => $alumno_id,
                    'carrera_id' => $carrera_id
                ])->latest()->first();

                $año = $alumno_carrera->año;
            }
        } else {
            return redirect()->back()->with(['alert_success' => 'Tu matriculación ya fue verificada, no puedes editarla.']);
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
            'discapacidad_mental'      => ['required'],
            'discapacidad_visual'      => ['required'],
            'discapacidad_motriz'      => ['required'],
            'acompañamiento_motriz'    => ['required'],
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
                'año'   => $año,
                'ciclo_lectivo' => date('Y')
            ]);

            if (isset($request['materias'])) {
                $this->procesoService->inscribir($alumno->id, $request['materias']);
            }

            Mail::to($request['email'])->send(new MatriculacionSuccessEmail($alumno, $carrera));


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

        $carrera = Carrera::find($carrera_id);

        $alumno_carrera = AlumnoCarrera::where([
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera->id,
            'ciclo_lectivo' => date('Y')
        ])->first();

        $datos = [
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera->id,
            'año'   => $año,
            'ciclo_lectivo' => date('Y')
        ];

        if (!$alumno_carrera) {
            $alumno_carrera = AlumnoCarrera::create($datos);
        } else {
            $alumno_carrera->update($datos);
        }

        if (isset($request['materias'])) {
            Proceso::where(['alumno_id' => $alumno->id, 'ciclo_lectivo' => date('Y')])->delete();
            $this->procesoService->inscribir($alumno->id, $request['materias']);
        }

        $alumno->update($request->all());

        if (!Session::has('coordinador') && !Session::has('seccionAlumnos') && !Session::has('admin')) {
            Mail::to($request['email'])->send(new MatriculacionSuccessEmail($alumno, $carrera));
        }

        return redirect()->route('matriculacion.edit', [
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera_id,
            'year'      => $año
        ])->with([
            'mensaje_editado' => 'Datos editados correctamente'
        ]);
    }

    public function delete(Request $request, $id, $carrera_id, $año = null)
    {
        $alumno = Alumno::find($id);
        $carrera = Carrera::find($carrera_id);

        $procesos = Proceso::where('alumno_id', $alumno->id)->get();

        foreach ($procesos as $proceso) {
            if ($proceso->materia->carrera_id == $carrera->id) {
                Asistencia::where('proceso_id',$proceso->id)->delete();
                ProcesoCalificacion::where('proceso_id',$proceso->id)->delete();
                $proceso->delete();
            }
        }

        AlumnoCarrera::where([
            'alumno_id' => $alumno->id,
            'carrera_id' => $carrera->id
        ])->delete();

        if($alumno->carreras()->count() == 0)
        {
            if ($alumno->comisiones()) {
                $alumno->comisiones()->detach();
            }
    
            if ($alumno->user_id) {
                $user = User::find($alumno->user_id);
    
                if ($user) {
                    if($user->carreras())
                    {
                        $user->carreras()->detach();
                    }

                    if($user->roles())
                    {
                        $user->roles()->detach();
                    }
                    $user->delete();
                }
            }
    
            $alumno->delete();

            return redirect()->route('alumno.carrera', [
                'carrera_id' => $carrera->id
            ])->with([
                'alumno_deleted' => 'Alumno eliminado, se le ha enviado un correo con una notificación'
            ]);
        }else{
            return redirect()->back()->with(['alert_warning'=>'Se ha eliminado la matriculación, y se le ha enviado un correo con una notificación al alumno']);
        }

        Mail::to($alumno->email)->send(new MatriculacionDeleted($alumno, $carrera, $request));

        
    }


    public function send_email(Request $request, $carrera_id, $año)
    {
        $validate = $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $mail_check = MailCheck::where('email', $request['email'])->first();

        if ($mail_check && $mail_check->checked) {
            $alumno = Alumno::where('email', $mail_check->email)->first();

            if ($alumno && $alumno->lastProcesoCarrera($carrera_id)) {
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
        $mail_check = $this->mailService->checkEmail($timecheck);

        return redirect()->route('matriculacion.create', [
            'id' => $carrera_id,
            'year' => $año,
            'timecheck' => $timecheck
        ]);
    }
}
