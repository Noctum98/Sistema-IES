<?php

namespace App\Http\Controllers;

use App\Models\Instancia;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Mesa;

class MesaController extends Controller
{
    protected $feriados;

    public function __construct()
    {
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
            '13-03-2022'
        ];
    }
    // Vistas
    public function vista_inscripciones($id){
        $primer_llamado = [];
        $segundo_llamado = [];

        $mesa = Mesa::where([
            'id' => $id,
        ])->first();

        foreach($mesa->mesa_inscriptos as $inscripcion){
            if($inscripcion->segundo_llamado){
                array_push($segundo_llamado,$inscripcion);
            }else{
                array_push($primer_llamado,$inscripcion);
            }
        }

        return view('mesa.inscripciones',[
            'mesa' => $mesa,
            'primer_llamado' => $primer_llamado,
            'segundo_llamado' => $segundo_llamado
        ]);
    }
    // Funcionalidades
    public function crear(Request $request, $materia_id,$instancia_id)
    {
        $validate = $this->validate($request, [
            'fecha'         => ['required'],
            'presidente'    => ['required', 'string'],
            'primer_vocal'  => ['required', 'string'],
            'segundo_vocal' => ['required', 'string']
        ]);

        $materia = Materia::find($materia_id);
        $instancia = Instancia::find($instancia_id);

        $fecha_dia = date("d-m-Y", strtotime($request['fecha']));
        $fecha_dia_segundo = date("d-m-Y", strtotime($request['fecha_segundo']));
        $comp_primer_llamado = in_array($fecha_dia,$this->feriados);
        $comp_segundo_llamado = in_array($fecha_dia_segundo,$this->feriados);

        if($comp_primer_llamado || $comp_segundo_llamado){
            if($comp_primer_llamado && $comp_segundo_llamado){
                $mensaje = "Las fechas ".$fecha_dia." y ".$fecha_dia_segundo." estan bloqueadas introduce otra fecha.";
            }elseif($comp_primer_llamado && !$comp_segundo_llamado){
                $mensaje = "La fecha ".$fecha_dia." esta bloqueada, prueba con otra.";
            }else{
                $mensaje = "La fecha ".$fecha_dia_segundo." esta bloqueada, prueba con otra.";
            }

            return redirect()->route('mesa.carreras',[
                'sede_id' => $materia->carrera->sede->id,
                'instancia_id' => $instancia->id
            ])->with([
                'error_fecha' => $mensaje
            ]);
        }
        
        $mesa_verified = Mesa::where([
            'materia_id' => $materia->id,
            'instancia_id' => $instancia->id
        ])->first();

        if($mesa_verified){
            return redirect()->route('mesa.carreras', [
                'sede_id' => $materia->carrera->sede->id,
                'instancia_id' => $instancia->id
            ]);
        }
 
        $mesa = new Mesa();
        $mesa->instancia_id = $instancia->id;
        $mesa->materia_id = $materia->id;
        $mesa->presidente = $request->input('presidente');
        $mesa->primer_vocal = $request->input('primer_vocal');
        $mesa->segundo_vocal = $request->input('segundo_vocal');
        $mesa->fecha = $request->input('fecha');
        $mesa->fecha_segundo = $request->input('fecha_segundo') ? $request->input('fecha_segundo'): null;
        $mesa->presidente_segundo = $request->input('presidente_segundo') ? $request->input('presidente_segundo'): null;
        $mesa->primer_vocal_segundo = $request->input('primer_vocal_segundo') ? $request->input('primer_vocal_segundo') : null;
        $mesa->segundo_vocal_segundo = $request->input('segundo_vocal_segundo') ? $request->input('segundo_vocal_segundo') : null;

        if (date('D', strtotime($mesa->fecha)) == 'Mon' || date('D', strtotime($mesa->fecha)) == 'Tue') {
            $mesa->cierre = strtotime($mesa->fecha . "-4 days");
        } else {
            $mesa->cierre = strtotime($mesa->fecha . "-2 days");
        }
        if ($request->input('fecha_segundo') && date('D', strtotime($mesa->fecha_segundo)) == 'Mon' || date('D', strtotime($mesa->fecha_segundo)) == 'Tue') {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-4 days");
        } else {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-2 days");
        }
        $mesa->save();

        return redirect()->route('mesa.carreras', [
            'sede_id' => $materia->carrera->sede->id,
            'instancia_id' => $instancia->id
        ])->with([
            'message' => 'Mesa ' . $materia->nombre . ' configurada correctamente'
        ]);
    }

    public function editar(Request $request, $materia_id,$instancia_id){

        $validate = $this->validate($request, [
            'fecha' => ['required'],
            'presidente'    => ['required', 'string'],
            'primer_vocal'  => ['required', 'string'],
            'segundo_vocal' => ['required', 'string']
        ]);

        $mesa = Mesa::where([
            'materia_id' => $materia_id,
            'instancia_id' => $instancia_id
        ])->first();

        $mesa->presidente = $request->input('presidente');
        $mesa->primer_vocal = $request->input('primer_vocal');
        $mesa->segundo_vocal = $request->input('segundo_vocal');
        $mesa->fecha = $request->input('fecha');
        $mesa->fecha_segundo = $request->input('fecha_segundo');
        $mesa->presidente_segundo = $request->input('presidente_segundo');
        $mesa->primer_vocal_segundo = $request->input('primer_vocal_segundo');
        $mesa->segundo_vocal_segundo = $request->input('segundo_vocal_segundo');

        if (date('D', strtotime($mesa->fecha)) == 'Mon' || date('D', strtotime($mesa->fecha)) == 'Tue') {
            $mesa->cierre = strtotime($mesa->fecha . "-4 days");
        } else {
            $mesa->cierre = strtotime($mesa->fecha . "-2 days");
        }
        if (date('D', strtotime($mesa->fecha_segundo)) == 'Mon' || date('D', strtotime($mesa->fecha_segundo)) == 'Tue') {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-4 days");
        } else {
            $mesa->cierre_segundo = strtotime($mesa->fecha_segundo . "-2 days");
        }
        $mesa->update();

        return redirect()->route('mesa.carreras', [
            'sede_id' => $mesa->materia->carrera->sede->id,
            'instancia_id' => $mesa->instancia_id
        ])->with([
            'message_edit' => 'Mesa ' . $mesa->materia->nombre . ' editada correctamente'
        ]);
    }
}
