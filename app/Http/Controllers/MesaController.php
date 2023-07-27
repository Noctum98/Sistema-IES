<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Instancia;
use App\Models\Libro;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\Proceso;
use App\Services\MesaService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MesaController extends Controller
{
    protected $feriados;
    protected $mesaService;

    const T_M = '14:00';
    const T_T = '23:59';
    const T_V = '23:59';


    public function __construct(
        MesaService $mesaService
    )
    {
        $this->mesaService = $mesaService;
        /**
         * Fuente https://www.argentina.gob.ar/interior/feriados-nacionales-2022
         */

        $this->feriados = [
            '19-02-2022',
            '20-02-2022',
            '26-02-2022',
            '27-02-2022',
            '28-02-2022',
            '01-03-2022',
            '05-03-2022',
            '06-03-2022',
            '12-03-2022',
            '13-03-2022',
            '09-07-2022',
            '15-08-2022',
            '25-08-2022',
            '02-09-2022',
            '07-10-2022',
            '10-10-2022',
            '20-11-2022',
            '21-11-2022',
            '08-12-2022',
            '09-12-2022',
        ];


    }

    // Vistas
    public function vista_inscripciones(Request $request, $instancia_id, $materia_id, $comision_id = null)
    {
        $primer_llamado = [];
        $primer_llamado_bajas = [];
        $segundo_llamado = [];
        $segundo_llamado_bajas = [];

        $procesos = $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)->orderBy('alumnos.apellidos')->get();

        $dataQuery = [
            'instancia_id' => $instancia_id,
            'materia_id' => $materia_id,
        ];

        if ($comision_id) {
            $dataQuery['comision_id'] = $comision_id;
        }


        $mesa = Mesa::where($dataQuery)->first();

        if ($mesa) {
            $contador_segundo_llamado = 0;
            $contador_primer_llamado = 0;
            foreach ($mesa->mesa_inscriptos_total as $inscripcion) {
                if ($inscripcion->segundo_llamado) {
                    if ($inscripcion->estado_baja) {
                        $segundo_llamado_bajas[] = $inscripcion;
                    } else {
                        $contador_segundo_llamado++;
                        $segundo_llamado[] = $inscripcion;
                    }
                } else {
                    if ($inscripcion->estado_baja) {
                        $primer_llamado_bajas[] = $inscripcion;
                    } else {
                        $contador_primer_llamado++;
                        $primer_llamado[] = $inscripcion;
                    }
                }
            }

            $folios_segundo = 1;
            $folios = 1;
            if($contador_primer_llamado > 26)
            {
                $division_primero = $contador_primer_llamado / 26;
                $folios = ceil($division_primero);
            }

            if($contador_segundo_llamado > 26)
            {
                $division_segundo = $contador_segundo_llamado / 26;
                $folios_segundo = ceil($division_segundo);
            }

            //dd($folios,$folios_segundo);
        } else {
            return redirect()->back()->with(['alert_danger' => 'La mesa indicada no existe.']);
        }

        return view('mesa.inscripciones', [
            'mesa' => $mesa,
            'primer_llamado' => $primer_llamado,
            'segundo_llamado' => $segundo_llamado,
            'primer_llamado_bajas' => $primer_llamado_bajas,
            'segundo_llamado_bajas' => $segundo_llamado_bajas,
            'instancia' => $mesa->instancia,
            'procesos' => $procesos,
            'folios' => $folios,
            'folios_segundo' => $folios_segundo
        ]);
    }



    // Funcionalidades
    public function crear(Request $request, $materia_id, $instancia_id)
    {
        $validate = $this->validate($request, [
            'fecha' => ['required'],
            'presidente_id' => ['required'],
            'fecha' => ['date'],
            'fecha_segundo' => ['date']
        ]);

        $materia = Materia::find($materia_id);
        $instancia = Instancia::find($instancia_id);

        $fecha_dia = date("d-m-Y", strtotime($request['fecha']));
        $fecha_dia_segundo = date("d-m-Y", strtotime($request['fecha_segundo']));

        $comp_primer_llamado = in_array($fecha_dia, $this->feriados);
        $comp_segundo_llamado = in_array($fecha_dia_segundo, $this->feriados);

        if ($comp_primer_llamado || $comp_segundo_llamado) {
            if ($comp_primer_llamado && $comp_segundo_llamado) {
                $mensaje = "Las fechas ".$fecha_dia." y ".$fecha_dia_segundo." están bloqueadas introduce otra fecha.";
            } elseif ($comp_primer_llamado && !$comp_segundo_llamado) {
                $mensaje = "La fecha ".$fecha_dia." está bloqueada, prueba con otra.";
            } else {
                $mensaje = "La fecha ".$fecha_dia_segundo." está bloqueada, prueba con otra.";
            }

            return redirect()->back()->with([
                'alert_danger' => $mensaje,
            ]);
        }

        $condicion = [
            'materia_id' => $materia->id,
            'instancia_id' => $instancia->id,
        ];

        if ($request['comision_id']) {
            $condicion['comision_id'] = $request['comision_id'];
        }

        $mesa_verified = Mesa::where($condicion)->first();

        $request['instancia_id'] = $instancia->id;
        $request['materia_id'] = $materia->id;

        $request['cierre'] = $this->mesaService->setCierreMesa($request['fecha'],$materia);
        if ($request['fecha_segundo']) {
            $request['cierre_segundo'] = $this->mesaService->setCierreMesa($request['fecha_segundo'],$materia);
        } else {
            $request['cierre_segundo'] = null;
        }


        if ($mesa_verified) {
            $mesa = $mesa_verified->update($request->all());
        } else {
            $mesa = Mesa::create($request->all());
        }

        return redirect()->back()->with([
            'message_success' => 'Mesa '.$materia->nombre.' configurada correctamente',
        ]);
    }

    public function updateLibroFolio(Request $request, $id)
    {
        $mesa = Mesa::find($id);

        $mesa->update($request->all());

        return redirect()->back()->with(['alert_success' => 'Libro y Folio establecidos']);
    }

    public function generar_pdf_mesa(Instancia $instancia, Carrera $carrera, int $llamado = 1, int $comision = null)
    {
        $texto_llamado = 'Primer llamado';

        if ($llamado == 2) {
            $texto_llamado = 'Segundo llamado';
        }
//        if (!$llamado) {
//            $llamado = 1;
//        }

        $etiqueta_espacio = 'Espacio Curricular';
        $etiquetas_espacios = 'Espacios Curriculares';

        if($carrera->tipo == 'modular' || $carrera->tipo == 'modular2'){
            $etiqueta_espacio = 'Módulo';
            $etiquetas_espacios = 'Módulos';
        }
//dd($carrera->materias()->get()[0]->mesas_instancias($instancia->id)[1]->comision()->get());
//dd($carrera->materias()->get()[5]->comisiones()->get());
        $data = [
            'instancia' => $instancia,
            'carrera' => $carrera,
            'texto_llamado' => $texto_llamado,
            'llamado' => $llamado,
            'etiqueta' => $etiqueta_espacio,
            'etiquetas' => $etiquetas_espacios,

        ];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdfs.mesa_generar_pdf ', $data);

        return $pdf->download('Tribunal Mesa '.$carrera->sede->nombre.'-'.$carrera->nombre.'-'.$carrera->resolucion.'-'.$llamado.'-'. $instancia->nombre.'.pdf');
    }

    public function generar_pdf_acta_volante(
        Instancia $instancia,
        Carrera $carrera,
        Materia $materia,
        int $llamado,
        int $orden,
        Comision $comision = null
    ) {


        $texto_llamado = 'Primer llamado';

        if ($llamado == 2) {
            $texto_llamado = 'Segundo llamado';
        }

        $mesa = Mesa::where([
            'instancia_id' => $instancia->id,
            'materia_id' => $materia->id,
        ]);
        if ($comision) {
            $mesa = $mesa->where('comision_id', $comision->id);
        }
        $mesa = $mesa->first();

        if (!$mesa) {
            throw new HttpResponseException(new Response('No se encontró la instancia correspondiente'));
        }

        $libro = Libro::where(['mesa_id'=>$mesa->id,'orden'=>$orden,'llamado'=>$llamado])->first();

        Log::info('MesaController - acta_volante');
        Log::info($mesa);
        Log::info($comision);
        Log::info($instancia);
        Log::info($carrera);

        $data = [
            'instancia' => $instancia,
            'carrera' => $carrera,
            'texto_llamado' => $texto_llamado,
            'llamado' => $llamado,
            'materia' => $materia,
            'mesa' => $mesa,
            'libro' => $libro,
            'orden' => $orden
        ];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdfs.mesa_acta_volante_pdf', $data);

        return $pdf->download('Acta Volante: '.$materia->nombre .'-'.$instancia->nombre.'.pdf');
    }

    public function mesaByComision(Request $request, $materia_id, $instancia_id, $comision_id = null)
    {
        $datos = ['materia_id' => $materia_id, 'instancia_id' => $instancia_id];

        if ($comision_id) {
            $datos['comision_id'] = $comision_id;
        }

        $mesa = Mesa::where($datos)
            ->with(
                'presidente_mesa',
                'primer_vocal_mesa',
                'segundo_vocal_mesa',
                'presidente_segundo_mesa',
                'primer_vocal_segundo_mesa',
                'segundo_vocal_segundo_mesa'
            )
            ->first();
        if($mesa)
        {
            $datos = [
                'status'=>'success',
                'mesa' => $mesa
            ];
        }else{
            $datos = [
                'status'=>'error',
                'mesa' => 'No existe una mesa creada'
            ];
        }

        return response()->json($datos,200);
    }

    public function cierreProfesor(Request $request,$id)
    {
        $mesa = Mesa::find($id);

        if($request['llamado'] == "1")
        {
            $mesa->cierre_profesor = true;
            $mesa->fecha_cierre_profesor = Carbon::now();
        }else{
            $mesa->cierre_profesor_segundo = true;
            $mesa->fecha_cierre_profesor_segundo = Carbon::now();
        }

        $mesa->update();

        return redirect()->back()->with(['alert_success'=>'El acta volante se ha cerrado correctamente.']);
    }

    public function abrirProfesor(Request $request,$id)
    {
        $mesa = Mesa::find($id);

        if($request['llamado'] == "1")
        {
            $mesa->cierre_profesor = false;
            $mesa->fecha_cierre_profesor = null;
        }else{
            $mesa->cierre_profesor_segundo = false;
            $mesa->fecha_cierre_profesor_segundo = null;
        }

        $mesa->update();

        return redirect()->back()->with(['alert_success'=>'El acta volante se ha abierto correctamente.']);
    }


    /**
     * @param int $instancia
     * @return Application|Factory|View
     */
    public function vistaCronograma(int $instancia)
    {
        $instanciaGet = Instancia::find($instancia);
        $user = Auth::user();

        $mesa = new Mesa();
        $carreras = $mesa->obtenerCarrerasByInstancia($instancia, $user);

        return view('mesa.cronograma')->with([
            'carreras' => $carreras,
            'instancia' => $instancia,
            'instancia_model' => $instanciaGet
        ]);
    }
}
