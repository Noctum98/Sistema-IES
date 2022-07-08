<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Comision;
use App\Models\Estados;
use App\Models\Materia;
use App\Models\Proceso;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProcesoController extends Controller
{
    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente-profesor');
    }
    // Vistas
    public function vista_inscribir($id)
    {
        $alumno = Alumno::find($id);
        $materias = Materia::where('carrera_id', $alumno->carrera_id)->get();
        $procesos = Proceso::orderBy('estado')->where('alumno_id', $alumno->id)->get();
        $mis_materias = [];
        $mis_materias = $materias->toArray();

        for ($contador = 0; $contador < count($mis_materias); $contador++) {
            foreach ($procesos as $proceso) {
                if ($proceso->materia_id == $mis_materias[$contador]['id']) {
                    unset($mis_materias[$contador]);
                    $mis_materias = array_values($mis_materias);
                }
            }
        }

        return view('alumno.enroll', [
            'alumno'    =>  $alumno,
            'materias'  =>  $mis_materias,
            'procesos'  => $procesos,
        ]);
    }

    public function vista_detalle(int $id)
    {
        $proceso = Proceso::find($id);

        return view('proceso.detail', [
            'proceso'   =>  $proceso
        ]);
    }

    public function vista_listado($materia_id, $cargo_id =  null, $comision_id = null)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id);

        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno',function($query) use ($comision_id){
                $query->whereHas('comisiones',function($query) use ($comision_id){
                    $query->where('comisiones.id',$comision_id);
                });
            });
        }
        $materia = Materia::find($materia_id);
        $comision =  null;
        if($comision_id){
            $comision = Comision::find($comision_id);
        }
        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();
        $calificacion = Calificacion::where([
           'materia_id' => $materia_id
        ]);
        if($comision_id){
            $calificacion->where([
                'comision_id' => $comision_id
            ]);
        }
        $calificaciones = $calificacion->orderBy('tipo_id','DESC')->get();
        $estados = Estados::all();

        return view('proceso.listado', [
            'procesos'   =>  $procesos,
            'materia' => $materia,
            'comision' => $comision,
            'calificaciones' => $calificaciones,
            'estados'=>$estados
        ]);
    }

    public function vista_listado_modular($materia_id, $cargo_id, $comision_id = null)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id);

        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno',function($query) use ($comision_id){
                $query->whereHas('comisiones',function($query) use ($comision_id){
                    $query->where('comisiones.id',$comision_id);
                });
            });
        }
        $materia = Materia::find($materia_id);
        $comision =  null;
        if($comision_id){
            $comision = Comision::find($comision_id);
        }
        $procesos->orderBy('alumnos.apellidos', 'asc');
        $procesos = $procesos->get();
        $calificacion = Calificacion::where([
            'materia_id' => $materia_id
        ]);
        if($comision_id){
            $calificacion->where([
                'comision_id' => $comision_id
            ]);
        }
        $calificaciones = $calificacion->orderBy('tipo_id','DESC')->get();
        $estados = Estados::all();

        return view('proceso.listado', [
            'procesos'   =>  $procesos,
            'materia' => $materia,
            'comision' => $comision,
            'calificaciones' => $calificaciones,
            'estados'=>$estados
        ]);
    }

    public function administrar(Request $request, $id)
    {
        $alumno = Alumno::find($id);
        $procesos = $request['materias'];

        foreach ($alumno->procesos as $proceso) {

            if (!$procesos || !in_array($proceso->materia_id, $procesos)) {
                $proceso->delete();
            }
        }

        if ($procesos) {
            // Si el rol que viene en el form ya lo tiene no lo crea y pasa al siguiente
            foreach ($procesos as $key => $proceso) {
                if ($alumno->hasProceso($proceso)) {
                    $proceso = null;
                }
                if ($proceso) {
                    Proceso::create([
                        'alumno_id' => $alumno->id,
                        'estado'    => 'en curso',
                        'materia_id' => $proceso
                    ]);
                }
            }
        }


        return redirect()->route('alumno.detalle', [
            'id' => $alumno->id
        ])->with([
            'mensaje_procesos' => 'Se han actualizado los procesos'
        ]);
    }

    public function cambiaEstado(Request $request): JsonResponse
    {
        $user = Auth::user();
        $proceso = Proceso::find($request['proceso_id']);
        $proceso->estado_id = (int) $request['estado_id'];
        $proceso->operador_id = $user->id;
        $proceso->update();

        return response()->json('¡Proceso actualizado!',200);
    }
    public function cambiaCierre(Request $request): JsonResponse
    {
        $user = Auth::user();
        $proceso = Proceso::find($request['proceso_id']);
        if($request['cierre'] == 'true'){
            $proceso->cierre = 1;
        }
        if($request['cierre'] == 'false'){
            $proceso->cierre = 0;
        }
        $proceso->operador_id = $user->id;

        $proceso->update();

        return response()->json('¡Proceso actualizado!',200);
    }

    public function cambia_nota_final(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'proceso_id' => ['required','integer'],
            'nota_final' => ['required','integer','max:10']
        ]);

        if(!$validate->fails()){
            $proceso = Proceso::find($request['proceso_id']);
            $proceso->final_calificaciones = $request['nota_final'];
            $proceso->update();

            $response = [
                'code' => 200,
                'nota' => $proceso->final_calificaciones
            ];

        }else{
            $response = [
                'code' => 200,
                'errors' => $validate->errors()
            ];
        }

        return response()->json($response,$response['code']);
    }
}
