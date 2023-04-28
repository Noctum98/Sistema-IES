<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Sede;
use App\Services\AlumnoService;
use App\Services\CicloLectivoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{

    protected $alumnoService;
    /**
     * @var CicloLectivoService $cicloLectivoService
     */
    private $cicloLectivoService;

    /**
     * @param AlumnoService $alumnoService
     * @param CicloLectivoService $cicloLectivoService
     */
    public function __construct(
        AlumnoService       $alumnoService,
        CicloLectivoService $cicloLectivoService
    )
    {
        $this->middleware('app.auth', ['except' => ['descargar_archivo', 'descargar_ficha']]);
        $this->middleware(
            'app.roles:admin-coordinador-regente-seccionAlumnos-areaSocial-equivalencias',
            ['only' => ['vista_admin', 'vista_alumnos', 'vista_elegir', 'vista_equivalencias']]
        );
        $this->alumnoService = $alumnoService;
        $this->cicloLectivoService = $cicloLectivoService;
    }

    // Vistas
    public function vista_admin(Request $request)
    {
//        dd(46);
        $user = Auth::user();
        $alumnos = [];
        $sedes = null;
        $busqueda = null;
        $sedes = $user->sedes;
//        $ciclo_lectivo = date('Y');

        if (isset($request['busqueda'])) {
            $alumnos = $this->alumnoService->buscarAlumnos($request);
            $busqueda = $request['busqueda'] ?? true;
        }
//        if (isset($request['ciclo_lectivo'])) {
        $ciclo_lectivo = $request['ciclo_lectivo'] ?? date('Y');
//        }


//        list($last, $ahora) = $this->cicloLectivoService->getCicloInicialYActual();


        //dd($alumnos);
        $data = [
            'alumnos' => $alumnos,
            'sedes' => $sedes,
            'busqueda' => $busqueda,
            'carrera_id' => $request['carrera_id'],
            'materia_id' => $request['materia_id'],
            'cohorte' => $request['cohorte'],
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            'ciclo_lectivo' => $ciclo_lectivo
        ];

        return view('alumno.admin', $data);
    }

    public function vista_equivalencias(Request $request)
    {

        $user = Auth::user();
        $alumnos = [];
        $sedes = null;
        $busqueda = null;
        $sedes = $user->sedes;


        if (isset($request['busqueda']) && $request['busqueda'] !='') {
            $alumnos = $this->alumnoService->buscarAlumnos($request);
            $busqueda = $request['busqueda'] ?? true;
        }

        $ciclo_lectivo = $request['ciclo_lectivo'] ?? date('Y');


//        list($last, $ahora) = $this->cicloLectivoService->getCicloInicialYActual();


        //dd($alumnos);
        $data = [
            'alumnos' => $alumnos,
            'sedes' => $sedes,
            'busqueda' => $busqueda,
            'carrera_id' => $request['carrera_id'],
            'materia_id' => $request['materia_id'],
            'cohorte' => $request['cohorte'],
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            'ciclo_lectivo' => $ciclo_lectivo
        ];

        return view('alumno.equivalencias', $data);
    }

    public function vista_elegir()
    {
        $carreras = Carrera::orderBy('sede_id')->get();

        return view('alumno.choice', [
            'carreras' => $carreras,
        ]);
    }

    public function vista_crear(int $id)
    {
        $carrera = Carrera::find($id);

        return view('alumno.create', [
            'carrera' => $carrera,
        ]);
    }

    public function vista_editar(int $id)
    {
        $alumno = Alumno::find($id);
        $carreras = Carrera::all();

        return view('alumno.edit', [
            'alumno' => $alumno,
            'carreras' => $carreras,
        ]);
    }

    public function vista_alumnos(Request $request, $carrera_id, $ciclo_lectivo = null)
    {
        $carrera = Carrera::find($carrera_id);

        $ciclo_lectivo = $ciclo_lectivo ?? date('Y');


        return view('alumno.alumnos', [
            'carrera' => $carrera,
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            'ciclo_lectivo' => $ciclo_lectivo
        ]);
    }

    public function vista_detalle(int $id, $ciclo_lectivo = null)
    {
        $alumno = Alumno::find($id);

        $carreras = $carreras = Carrera::select('carreras.*')
            ->distinct()
            ->join('alumno_carrera', 'carreras.id', '=', 'alumno_carrera.carrera_id')
            ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
            ->where('alumnos.id', $alumno->id)
            ->get();

        if (!$alumno) {
            return redirect()->route('alumno.admin')->with([
                'alumno_notIsset' => 'El alumno no existe',
            ]);
        }

        $ciclo_lectivo = $ciclo_lectivo ?? date('Y');

        $pase = true;
        if (Session::has('alumno') && (!Session::has('coordinador') || Session::has('admin'))) {
            if (Auth::user()->id != $alumno->user_id) {
                $pase = false;
            }
        }

        if ($pase) {
            return view('alumno.detail', [
                'alumno' => $alumno,
                'carreras' => $carreras,
                'ciclo_lectivo' => $ciclo_lectivo
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function vista_datos(Request $request, $sede_id = null, $carrera_id = null, $localidad = null, $edad = null)
    {
        $data = [];
        if ($sede_id) {

            $discapacidad_visual = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                return $query->where('sede_id', $sede_id);
            })->where('discapacidad_visual', true)->count();

            $discapacidad_motriz = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                return $query->where('sede_id', $sede_id);
            })->where('discapacidad_motriz', true)->count();


            $discapacidad_mental = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                return $query->where('sede_id', $sede_id);
            })->where('discapacidad_mental', true)->count();

            $discapacidad_intelectual = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                return $query->where('sede_id', $sede_id);
            })->where('discapacidad_intelectual', '!=', 'ninguna')->count();

            $discapacidad_auditiva = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                return $query->where('sede_id', $sede_id);
            })->where('discapacidad_auditiva', '!=', 'ninguna')->count();

            $poblacion_indigena = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                return $query->where('sede_id', $sede_id);
            })->where('poblacion_indigena', true)->count();

            $privacidad = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                return $query->where('sede_id', $sede_id);
            })->where('privacidad', true)->count();

            $fuera_mendoza = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                return $query->where('sede_id', $sede_id);
            })->where('provincia', '!=', 'Mendoza')
                ->orWhere('provincia', '!=', 'mendoza')->count();


            if ($localidad && $localidad != 0) {
                $localidad_cantidad = Alumno::whereHas('carreras', function ($query) use ($sede_id) {
                    return $query->where('sede_id', $sede_id);
                })->where('localidad', $request['localidad'])->count();
            }

            if ($edad && $edad != 0) {
                $edades = Alumno::whereHas('carreras', function ($query) use ($sede_id, $carrera_id) {
                    if ($carrera_id && $carrera_id != 0) {
                        return $query->where('carreras.id', $carrera_id);
                    } else {
                        return $query->where('sede_id', $sede_id);
                    }
                })->where('edad', $edad)->count();
            }

            $data = [
                'status' => true,
                'edad' => $edad ?? null,
                'localidad' => $localidad ?? null,
                'sede_id' => $sede_id ?? null,
                'carrera_id' => $carrera_id ?? null,
                'edades' => $edades ?? null,
                'discapacidad_visual' => $discapacidad_visual ?? null,
                'discapacidad_motriz' => $discapacidad_motriz ?? null,
                'discapacidad_mental' => $discapacidad_mental ?? null,
                'discapacidad_intelectual' => $discapacidad_intelectual ?? null,
                'discapacidad_auditiva' => $discapacidad_auditiva ?? null,
                'poblacion_indigena' => $poblacion_indigena ?? null,
                'privacidad' => $privacidad ?? null,
                'localidad_cantidad' => $localidad_cantidad ?? null,
                'fuera_mendoza' => $fuera_mendoza ?? null,
            ];
        }

        $data['sedes'] = Sede::all();
        $data['carreras'] = Carrera::all();

        return view('estadistica.datos', $data);
    }


    public function buscar(Request $request, $id)
    {
        $alumno = $this->alumnoService->buscarAlumno($request['busqueda'], $id);

        if ($alumno) {
            $response = [
                'status' => 'success',
                'alumno' => $alumno,
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No existe alumno con este dni.',
            ];
        }

        return response()->json($response, 200);
    }

    public function alumnosMateria(Request $request, $materia_id)
    {
        $alumnos = $this->alumnoService->alumnosMateria($materia_id);

        return response()->json($alumnos, 200);
    }

    public function ver_foto(string $foto): Response
    {
        $archivo = Storage::disk('alumno_foto')->get($foto);

        return new Response($archivo, 200);
    }

    public function descargar_archivo(string $nombre, string $dni)
    {
        $disk = Storage::disk('google');

        $dir = '/';
        $recursive = false;
        $contents = collect($disk->listContents($dir, $recursive));
        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $dni)
            ->first();


        $dir_file = $dir['path'];
        $contents = collect($disk->listContents($dir_file, $recursive));

        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($nombre, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($nombre, PATHINFO_EXTENSION))
            ->first();


        $rawData = $disk->getDriver()->readStream($file['path']);

        if ($file) {
            return response()->stream(function () use ($rawData) {
                fpassthru($rawData);
            }, 200, [
                'Content-Type' => $file['mimetype'],
                //'Content-disposition' => 'attachment; filename="'.$filename.'"', // force download?
            ]);
        } else {
            return redirect()->route('alumno.detalle');
        }
    }

    public function descargar_ficha(int $id)
    {
        $alumno = Alumno::find($id);
        $carreras = $carreras = $carreras = Carrera::select('carreras.*')
            ->distinct()
            ->join('alumno_carrera', 'carreras.id', '=', 'alumno_carrera.carrera_id')
            ->join('alumnos', 'alumno_carrera.alumno_id', '=', 'alumnos.id')
            ->where('alumnos.id', $alumno->id)
            ->get();

        if ($alumno) {
            $data = [
                'alumno' => $alumno,
                'carreras' => $carreras
            ];

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView('pdfs.alumno_ficha', $data);

            return $pdf->stream('Ficha ' . $alumno->nombres . ' ' . $alumno->apellidos . '.pdf');
        } else {
            return view('error.error');
        }
    }
}
