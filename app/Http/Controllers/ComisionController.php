<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Materia;
use App\Models\Parameters\CicloLectivo;
use App\Models\User;
use App\Request\ComisionesRequest;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ComisionController extends Controller
{

    protected $userService;

    function __construct(
        UserService $userService
    )
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente-coordinador');
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index($carrera_id, Request $request)
    {
        $carrera = Carrera::find($carrera_id);

        $comisiones = Comision::where('carrera_id',$carrera->id);
        if($request->año){
            $comisiones->where('año', $request->año);
        }
        $comisiones = $comisiones->get();

        return view('comision.index', [
            'comisiones' => $comisiones,
            'carrera' => $carrera
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ComisionesRequest $request
     * @return RedirectResponse
     */
    public function store(ComisionesRequest $request): RedirectResponse
    {
        $comision = Comision::create($request->validated());
        $materias = Materia::where('carrera_id', $request->carrera_id)->where('año' , $request->año)->orderBy('nombre')->get();
        $comision->materias()->attach($materias);
        session()->flash(
            'success',
            "La nueva comisión {$comision->nombre} del año {$comision->año} fue creada"
        );

        return redirect()
            ->route('materia.admin',[
                'carrera_id' => $request->carrera_id,
            ])
            ->withSuccess(
                "La nueva comisión {$comision->nombre} del año {$comision->año} fue creada"
            );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $comision = Comision::find($id);
        $carrera_id = $comision->carrera_id;
        $año = $comision->año;
        $comisiones = Comision::select('nombre','id')->where([
            'carrera_id'=>$comision->carrera_id,
            'año' => $año
        ])->get();

        $profesores = $this->userService->listadoRol('profesor',false,$comision->carrera_id,false);

        $alumnos = Alumno::select('nombres','apellidos','id','comision_id')->whereHas('carreras',function($query) use ($carrera_id,$año){
            $query->where('carrera_id',$carrera_id)
            ->where('año',$año)
            ->where('ciclo_lectivo',date('Y'));
        })->orderBy('apellidos')->get();

        if($año == 2 || $año == 3)
        {
            $recursantes = Alumno::select('nombres','apellidos','id','comision_id')->whereHas('carreras',function($query) use ($carrera_id,$año){
                $query->where('carrera_id',$carrera_id)
                ->where('año',($año - 1))
                ->where('ciclo_lectivo',date('Y'));
            });

            if($año == 2 || $año == "2"){
                $recursantes = $recursantes->where('regularidad','!=','regular_primero')->orderBy('apellidos')->get();
            }elseif($año == 3 || $año == "3"){
                $recursantes = $recursantes->where('regularidad','!=','regular_segundo')->orderBy('apellidos')->get();
            }
        }

        // dd($recursantes);
        return view('comision.detail',[
            'comision' => $comision,
            'profesores' => $profesores,
            'alumnos' => $alumnos,
            'recursantes' => isset($recursantes) ? $recursantes : null,
            'comisiones' => $comisiones
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Comision $comision
     * @return Application|Factory|View
     */
    public function edit(Comision $comision_id)
    {

        return view('comision.modals.form_edit_comision')->with([
            'comision' => $comision_id

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ComisionesRequest $request

     */
    public function update(ComisionesRequest $request, $comision_id)
    {
        $comision = Comision::find($comision_id);
        $comision->update($request->validated());
        $mensaje = ['comision_update' => '¡Comision actualizada!'];
        return redirect()->route('comisiones.ver', [
            'carrera_id' => $comision->carrera_id,

        ])->with($mensaje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {

        $comision = Comision::find($id);

        $alumnos = Alumno::where('comision_id',$comision->id)->update([
            'comision_id' => null
        ]);
        $calificaciones = Calificacion::where('comision_id',$comision->id)->get();
          Calificacion::where('comision_id',$comision->id)->update([
            'comision_id' => null
        ]);

//         foreach ($calificaciones as $calificacion){
//             $procesos = ProcesoCalificacion::where([
//                 'calificacion_id' => $calificacion->id
//             ])->get();
//
//             foreach ($procesos as $proceso){
//                 $proceso->update([
//                     'nota' => ' ',
//                     'porcentaje' => ' '
//                 ]);
//             }
//         }

        if($comision->profesores())
        {
            $comision->profesores()->detach();
        }

        if($comision->materias())
        {
            $comision->materias()->detach();
        }

        $comision->delete();

        return redirect()->route('comisiones.ver',$comision->carrera_id)->with(
            'comision_eliminada','La comisión se eliminó con éxito'
        );
    }

    public function agregar_profesor(Request $request,$id){
        $comision = Comision::find($id);
        if(!$comision->hasProfesor($request['profesor_id'])){
            $comision->profesores()->attach(User::where('id',$request['profesor_id'])->first());
            $mensaje = ['mensaje_success' => 'El profesor se ha añadido correctamente.'];
        }else{
            $mensaje = [
                'mensaje_error' => 'El profesor ya existe en esta comisión.'
            ];
        }

        return redirect()->route('comisiones.show',$comision->id)->with($mensaje);
    }

    public function delete_profesor(Request $request,$id){
        $comision = Comision::find($id);

        if($comision->hasProfesor($request['profesor_id']))
        {
            $comision->profesores()->detach(User::where('id',$request['profesor_id'])->first());
            $mensaje = ['profesor_deleted'=>'El profesor se ha eliminado correctamente.'];
        }

        return redirect()->route('comisiones.show',$comision->id)->with($mensaje);
    }

    public function agregar_alumno(Request $request)
    {
        $alumno = Alumno::find($request['alumno_id']);

        $comision = Comision::find($request['comision_id']);

        if($request['detach'] == 'true'){
            $alumno->comisiones()->detach($comision);
            $mensaje = "Comisión desasignada.";
        }else{
            $alumno->comisiones()->attach($comision);
            $mensaje = "Comisión asignada.";
        }

        return response()->json($mensaje,200);
    }
}
