<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Asistencia;
use App\Models\AlumnoAsistencia;
use App\Models\Proceso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AsistenciaController extends Controller
{
    function __construct()
    {
        // $this->middleware('app.admin');
        // $this->middleware('app.roles:admin-profesor');
    }
    // Vistas
    public function vista_carreras(){
        $materias = Auth::user()->materias;
        $ruta = 'asis.admin';

        return view('asistencia.home',[
            'materias'  =>  $materias,
            'ruta'      =>  $ruta
        ]);
    }

    public function vista_admin(int $id){
        $materia = Materia::find($id);
        $procesos = Proceso::where('materia_id',$id)->get();

        return view('asistencia.admin',[
            'materia'       =>  $materia,
            'procesos'   =>  $procesos
        ]);
    }
    public function vista_fecha(int $id){
        $materia = Materia::find($id);

        return view('asistencia.date',[
            'materia'   =>  $materia
        ]);
    }
    public function vista_crear(int $id){
        $asistencia = Asistencia::find($id);
        $procesos = Proceso::where('materia_id',$asistencia->materia_id)->get();

        return view('asistencia.create',[
            'procesos'  =>  $procesos,
            'asistencia'   =>  $asistencia
        ]);
    }

    public function vista_cerrar(int $id){
        $procesos = Proceso::where('materia_id',$id)->get();
        $asistencias = Asistencia::where('materia_id',$id)->get();

        return view('asistencia.close',[
            'procesos'      =>  $procesos,
            'asistencias'   =>  $asistencias
        ]);
    }

    // Funcionalidades

    public function crear(Request $request){
        $validate = $this->validate($request,[
            'porcentaje_final'             =>  ['required','numeric'],
        ]);

        $issetAsistencia = Asistencia::where('proceso_id',$request['proceso_id'])->first();

        if($issetAsistencia){
            $issetAsistencia->porcentaje_final = $request['porcentaje_final'];
            $issetAsistencia->update();
            $asistencia = $issetAsistencia;
        }else{
            $asistencia = Asistencia::create($request->all());
        }

        return response()->json([
            'message' => 'Asistencia creada con éxito!',
            'asistencia' => $asistencia 
        ],200);
    }

    public function crear_7030(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'porcentaje_virtual'           =>  ['required','numeric','max:30'],
            'porcentaje_presencial'             =>  ['required','numeric','max:70']
        ]);

        if(!$validate->fails())
        {
            $issetAsistencia = Asistencia::where('proceso_id',$request['proceso_id'])->first();

            $request['porcentaje_final'] = (int) $request['porcentaje_virtual'] + $request['porcentaje_presencial'];
    
            if($issetAsistencia){
                $issetAsistencia->update($request->all());
                $asistencia = $issetAsistencia;
            }else{
                $asistencia = Asistencia::create($request->all());
            }
            
            $response = [
                'message' => 'Asistencia creada con éxito!',
                'asistencia' => $asistencia            
            ];

        }else{
            $response = [
                'message' => 'Error',
                'errors' => $validate->errors()
            ];
        }

       
        return response()->json($response,200);
        
    }
    public function cerrar_planilla(int $id){
        $procesos = Proceso::where('materia_id',$id)->get();
        $asistencias = Asistencia::where([
            'materia_id'    =>  $id
        ])->get();

        foreach ($procesos as $proceso){

            $presentes = 0;
            $total = 0;
            
            foreach($asistencias as $dia){
                foreach($dia->asistencias as $asistencia){
                    if($asistencia->alumno_id == $proceso->alumno_id){
                        $total++;
                        if($asistencia->estado == 'presente'){
                            $presentes++;
                        }
                    }
                }
            }
            $porcentaje = ($presentes * 100) / $total;

            $proceso->final_asistencia = round($porcentaje,2);

            if($proceso->final_parciales && $proceso->final_trabajos && $proceso->final_asistencia){
                if($proceso->final_parciales > 6 && $proceso->final_trabajos >= 6 && $porcentaje >= 70){
                    $proceso->estado = 'regular';
                }else{
                    $proceso->estado = 'irregular';
                }
            }
            $proceso->update();
        }

        return redirect()->route('asis.cerrar',[
           'id' =>  $id
        ]);
    }
}
