<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\TipoCalificacion;
use App\Models\User;
use App\Request\ComisionesRequest;
use App\Request\TipoCalificacionesRequest;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        $profesores = $this->userService->listadoRol('profesor',false,$comision->carrera_id,true);


        
        $alumnos = Alumno::select('nombres','apellidos','id','comision_id')->whereHas('carreras',function($query) use ($carrera_id,$año){
            $query->where('carrera_id',$carrera_id)
            ->where('año',$año);
        })->orderBy('apellidos')->get();

        return view('comision.detail',[
            'comision' => $comision,
            'profesores' => $profesores,
            'alumnos' => $alumnos,
            'comisiones' => $comisiones
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $comision = Comision::find($id);
        $alumnos = Alumno::where('comision_id',$comision->id)->update([
            'comision_id' => null
        ]);

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
            'comision_eliminada','La comisión se eliminó con exito!'
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
        $alumno->comision_id = (int) $request['comision_id'];
        $alumno->update();

        return response()->json('Comisión asignada!',200);
    }
}
