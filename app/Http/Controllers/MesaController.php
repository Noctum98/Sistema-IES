<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Instancia;
use App\Models\Sede;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\Proceso;
use App\Services\UserService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MesaController extends Controller
{
    protected $feriados;

    const T_M = '14:00';
    const T_T = '23:59';
    const T_V = '23:59';

   
    public function __construct()
    {
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

        //dd($mesa);

        if ($mesa) {
            foreach ($mesa->mesa_inscriptos as $inscripcion) {
                if ($inscripcion->segundo_llamado) {
                    if ($inscripcion->estado_baja) {
                        $segundo_llamado_bajas[] = $inscripcion;
                    } else {
                        $segundo_llamado[] = $inscripcion;
                    }
                } else {
                    if ($inscripcion->estado_baja) {
                        $primer_llamado_bajas[] = $inscripcion;
                    } else {
                        $primer_llamado[] = $inscripcion;
                    }
                }
            }
        } else {
            return redirect()->back()->with(['error_fecha' => 'La mesa indicada no existe.']);
        }

        return view('mesa.inscripciones', [
            'mesa' => $mesa,
            'primer_llamado' => $primer_llamado,
            'segundo_llamado' => $segundo_llamado,
            'primer_llamado_bajas' => $primer_llamado_bajas,
            'segundo_llamado_bajas' => $segundo_llamado_bajas,
            'instancia' => $mesa->instancia,
            'procesos' => $procesos,
        ]);
    }

    

    // Funcionalidades
    public function crear(Request $request, $materia_id, $instancia_id)
    {
        $validate = $this->validate($request, [
            'fecha' => ['required'],
            'presidente_id' => ['required'],
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
                'error_fecha' => $mensaje,
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

        if (date('D', strtotime($request['fecha'])) == 'Mon' || date('D', strtotime($request['fecha'])) == 'Tue') {
            $request['cierre'] = strtotime($this->setFechaTurno($materia, $request['fecha'])."-4 days");
        } else {
            $request['cierre'] = strtotime($this->setFechaTurno($materia, $request['fecha'])."-2 days");
        }
        if ($request['fecha_segundo']) {
            if ($request['fecha_segundo'] && date('D', strtotime($request['fecha_segundo'])) == 'Mon' || date(
                    'D',
                    strtotime($request['fecha_segundo'])
                ) == 'Tue') {
                    
                $request['cierre_segundo'] = strtotime($this->setFechaTurno($materia, $request['fecha_segundo'])."-4 days");
          

            } else {
                $request['cierre_segundo'] = strtotime($this->setFechaTurno($materia, $request['fecha_segundo'])."-2 days");
            }
        } else {
            $request['cierre_segundo'] = null;
        }


        if ($mesa_verified) {
            $mesa = $mesa_verified->update($request->all());
        } else {
            $mesa = Mesa::create($request->all());
        }

        return redirect()->back()->with([
            'message' => 'Mesa '.$materia->nombre.' configurada correctamente',
        ]);
    }

    public function updateLibroFolio(Request $request, $id)
    {
        $mesa = Mesa::find($id);

        $mesa->update($request->all());

        return redirect()->back()->with(['alumno_success' => 'Libro y Folio establecidos']);
    }

    public function generar_pdf_mesa(Instancia $instancia, Carrera $carrera, int $llamado = null)
    {
        $texto_llamado = 'Primer llamado';

        if ($llamado == 2) {
            $texto_llamado = 'Segundo llamado';
        }
        if (!$llamado) {
            $llamado = 1;
        }

        $etiqueta_espacio = 'Espacio Curricular';
        $etiquetas_espacios = 'Espacios Curriculares';

        if($carrera->tipo == 'modular' || $carrera->tipo == 'modular2'){
            $etiqueta_espacio = 'Módulo';
            $etiquetas_espacios = 'Módulos';
        }
//dd($carrera->materias()->get()[0]->mesas_instancias($instancia->id)[1]->comision()->get());
//dd($carrera->materias()->get()[0]->comisiones()->get());
        $data = [
            'instancia' => $instancia,
            'carrera' => $carrera,
            'texto_llamado' => $texto_llamado,
            'llamado' => $llamado,
            'etiqueta' => $etiqueta_espacio,
            'etiquetas' => $etiquetas_espacios,

        ];

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pdfs.mesa_generar_pdf ', $data);

        return $pdf->download('Tribunal Mesa '.$carrera->sede->nombre.'-'.$carrera->nombre.'-'.$carrera->resolucion.'-'.$llamado.'-'. $instancia->nombre.'.pdf');
    }

    public function generar_pdf_acta_volante(
        Instancia $instancia,
        Carrera $carrera,
        Materia $materia,
        int $llamado,
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
        ];

        $pdf = \App::make('dompdf.wrapper');
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
                'presidente',
                'primer_vocal',
                'segundo_vocal',
                'presidente_segundo',
                'primer_vocal_segundo',
                'segundo_vocal_segundo'
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

    private function setFechaTurno($materia, $fecha)
    {

        $turno = $materia->carrera->turno;
        $hora = '00:00';
        switch ($turno) {
            case 'mañana':
                $hora = $this::T_M;
                break;
            case 'tarde':
                $hora = $this::T_T;
                break;
            case 'vespertino':
                $hora = $this::T_V;
        }

        $fecha = substr($fecha, 0, -6);

        return $fecha.'T'.$hora;

    }
}
