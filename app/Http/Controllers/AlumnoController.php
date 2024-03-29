<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Alumno\EncuestaSocioeconomica;
use App\Models\Carrera;
use App\Models\Preinscripcion;
use App\Models\Sede;
use App\Services\Alumno\EncuestaSocioeconomicaService;
use App\Services\AlumnoService;
use App\Services\CicloLectivoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class AlumnoController extends Controller
{

    protected $alumnoService;
    protected $encuestaSocioeconomicaService;
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
        CicloLectivoService $cicloLectivoService,
        EncuestaSocioeconomicaService $encuestaSocioeconomicaService
    ) {
        $this->middleware('app.auth', ['except' => ['descargar_archivo', 'descargar_ficha']]);
        $this->middleware(
            'app.roles:admin-coordinador-regente-seccionAlumnos-areaSocial-equivalencias',
            ['only' => ['vista_admin', 'vista_alumnos', 'vista_elegir', 'vista_equivalencias']]
        );
        $this->middleware('app.roles:admin', ['only' => 'vista_datos']);
        $this->alumnoService = $alumnoService;
        $this->cicloLectivoService = $cicloLectivoService;
        $this->encuestaSocioeconomicaService = $encuestaSocioeconomicaService;
    }

    // Vistas
    public function vista_admin(Request $request)
    {
        $user = Auth::user();
        $alumnos = [];
        $sedes = null;
        $busqueda = null;
        $sedes = $user->sedes;
        if (isset($request['busqueda'])) {
            $alumnos = $this->alumnoService->buscarAlumnos($request);
            $busqueda = $request['busqueda'] ?? true;
        }
        $ciclo_lectivo = $request['ciclo_lectivo'] ?? date('Y');

        if (Session::has('admin') || Session::has('areaSocial') || Session::has('regente')) {

            if (Session::has('areaSocial')) {
                $sedesIds = $sedes->pluck('id')->toArray();
                $carreras = Carrera::whereIn('sede_id', $sedesIds)->orderBy('sede_id', 'asc')->get();
            } else {
                $carreras = Carrera::orderBy('sede_id', 'asc')->get();
            }
        } else {
            $carreras = $user->carreras;
        }

        $data = [
            'alumnos' => $alumnos,
            'carreras' => $carreras,
            'busqueda' => $busqueda,
            'carrera_id' => $request['carrera_id'],
            'materia_id' => $request['materia_id'],
            'cohorte' => $request['cohorte'],
            'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            'ciclo_lectivo' => $ciclo_lectivo,
            'sedes' => $sedes
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


        if (isset($request['busqueda']) && $request['busqueda'] != '') {
            $alumnos = $this->alumnoService->buscarAlumnos($request);
            $busqueda = $request['busqueda'] ?? true;
        }

        $ciclo_lectivo = $request['ciclo_lectivo'] ?? date('Y');


        //        list($last, $ahora) = $this->cicloLectivoService->getCicloInicialYActual();



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
        if (Session::has('alumno') && (!Session::has('coordinador') && !Session::has('admin') && !Session::has('regente') && !Session::has('areaSocial'))) {
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

    public function vista_datos(Request $request, $sede_id = null, $carrera_id = null, $año = null)
    {
        $data['sedes'] = Sede::all();
        $data['carreras'] = Carrera::all();
        $data['questions'] = [
            'Identidad de género' => 'identidad_genero',
            'Edades' => 'edad_encuesta',
            'Empresa de Teléfono' => 'empresa_telefono',
            'Accesso a Internet' => 'acceso_internet'
        ];

        return view('estadistica.datos', $data);
    }

    public function obtenerGraficos(Request $request, $sede_id = null, $carrera_id = null, $año = null)
    {
        $parameters = [
            'año' => $año,
            'carrera_id' => $carrera_id,
            'sede_id' => $sede_id
        ];
        $encuestas = EncuestaSocioeconomica::whereHas('alumno', function ($query) use ($parameters) {
            $query->whereHas('carreras', function ($query) use ($parameters) {
                $query->where('carreras.id', $parameters['carrera_id']);
            })->whereHas('carreras', function ($query) use ($parameters) {
                $query->where('año', $parameters['año']);
            });
        })->get();

        $datos = $this->encuestaSocioeconomicaService->formatearDatos($encuestas);

        $data = [];
        foreach ($datos as $key => $value) {
            $data[] = [
                'identificador' => $key,
                'labels' => $value['labels'],
                'data' => $value['data'],
                'type' => $value['type']
            ];
        }

        return response()->json(['data' => $data], 200);
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

    public function descargar_archivo(string $nombre, string $dni, int $id)
    {
        $preinscripcion = Preinscripcion::find($id);
        $disk = Storage::disk('google');

        if ($preinscripcion->gdrive_storage) {
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
                ]);
            }
        } else {
            $rutaArchivo = 'temp/' . $nombre;

            $rutaCompleta = storage_path("app/{$rutaArchivo}");

            $mimeType = mime_content_type($rutaCompleta);

            if (Storage::disk('local')->exists($rutaArchivo)) {
                $headers = [
                    'Content-Type' => $mimeType,
                ];

                return response()->file($rutaCompleta, $headers);
            } else {
                abort(404, 'Archivo no encontrado');
            }
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
