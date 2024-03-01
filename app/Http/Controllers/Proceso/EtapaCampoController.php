<?php

namespace App\Http\Controllers\Proceso;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtapaCampoRequest;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\Proceso\EtapaCampo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EtapaCampoController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador-profesor-regente-seccionAlumnos');    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$materia_id,$ciclo_lectivo,$comision_id)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('procesos.ciclo_lectivo', $ciclo_lectivo)
            ->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            })->get();
        $materia = Materia::find($materia_id);

        $data = [
            'procesos' => $procesos,
            'materia' => $materia,
            'ciclo_lectivo' => $ciclo_lectivo
        ];

        return view('proceso.etapa_campo',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EtapaCampoRequest $request)
    {
        $request = $this->calcularPorcentaje($request);

        $etapa_campo = EtapaCampo::create($request->all());

        return redirect()->back()->with(['alert_success'=>'Etapa de campo guardada.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $etapaCampo = EtapaCampo::with('proceso')->find($id);

        return response()->json($etapaCampo,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EtapaCampoRequest $request, $id)
    {
        $etapa_campo = EtapaCampo::find($id);

        $request = $this->calcularPorcentaje($request);

        $etapa_campo->update($request->all());

        return redirect()->back()->with(['alert_success'=>'Etapa de campo actualizada.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function habilitar(Request $request,$proceso_id,$habilitacion)
    {
        $proceso = Proceso::find($proceso_id);
        $proceso->update(['habilitado_campo'=>$habilitacion]);
        // Log::info($proceso_id);
        // Log::info($habilitacion);
        // Log::info($proceso);

        return response($proceso,200);
    }

    public function calcularPorcentaje($request)
    {
        $porcentaje_final = 0;
        $contador = 0;

        if(!empty($request['primera_evaluacion']) && is_numeric($request['primera_evaluacion'])){
            $porcentaje_final = $porcentaje_final + $request['primera_evaluacion'];
            $contador++;
        }

        if(!empty($request['segunda_evaluacion']) && is_numeric($request['segunda_evaluacion'])){
            $porcentaje_final = $porcentaje_final + $request['segunda_evaluacion'];
            $contador++;
        }

        if(!empty($request['tercera_evaluacion']) && is_numeric($request['tercera_evaluacion'])){
            $porcentaje_final = $porcentaje_final + $request['tercera_evaluacion'];
            $contador++;
        }

        if($contador > 0)
        {
            $request['porcentaje_final'] = number_format( $porcentaje_final / $contador,1);
        }

        return $request;
    }
}
