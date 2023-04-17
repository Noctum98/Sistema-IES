<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Calificacion;
use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Materia;
use App\Models\User;
use App\Request\ComisionesRequest;
use App\Services\AlumnoService;
use App\Services\CicloLectivoService;
use App\Services\ComisionService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ComisionController extends Controller
{

    protected $userService;
    protected $cicloLectivoService;
    protected $alumnoService;
    protected $comisionService;

    function __construct(
        UserService $userService,
        CicloLectivoService $cicloLectivoService,
        AlumnoService $alumnoService,
        ComisionService $comisionService
    ) {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente-coordinador');
        $this->userService = $userService;
        $this->cicloLectivoService = $cicloLectivoService;
        $this->alumnoService = $alumnoService;
        $this->comisionService = $comisionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request, $carrera_id, $ciclo_lectivo)
    {
        $carrera = Carrera::find($carrera_id);

        $comisiones = Comision::where('carrera_id', $carrera->id)
            ->where('ciclo_lectivo', $ciclo_lectivo);

        if ($request->año) {
            $comisiones->where('año', $request->año);
        }
        $comisiones = $comisiones->get();
        $ciclos_lectivos = $this->cicloLectivoService->getCicloInicialYActual();

        return view('comision.index', [
            'comisiones' => $comisiones,
            'carrera' => $carrera,
            'ciclos_lectivos' => $ciclos_lectivos,
            'ciclo_lectivo' => $ciclo_lectivo
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
        $materias = Materia::where('carrera_id', $request->carrera_id)->where('año', $request->año)->orderBy('nombre')->get();
        $comision = Comision::create($request->all());
        $comision->materias()->attach($materias);

        
        if($request['unica'] == 1)
        {
            $this->comisionService->storeUnicas($comision,$materias);
        }

        return redirect()
            ->route('materia.admin', [
                'carrera_id' => $request->carrera_id,
            ])
            ->with(["alert_success"=>"La nueva comisión {$comision->nombre} del año {$comision->año} fue creada"]);
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
        $comisiones = Comision::select('nombre', 'id','unica')->where([
            'carrera_id' => $comision->carrera_id,
            'año' => $año,
            'ciclo_lectivo' => $comision->ciclo_lectivo
        ])->get();

        $profesores = $this->userService->listadoRol('profesor', false, $comision->carrera_id, false);

        $alumnos = Alumno::select('nombres', 'apellidos', 'id', 'comision_id')->whereHas('carreras', function ($query) use ($carrera_id, $año, $comision) {
            $query->where('carrera_id', $carrera_id)
                ->where('año', $año)
                ->where('ciclo_lectivo', $comision->ciclo_lectivo);
        })->orderBy('apellidos')->get();

        if ($año == 2 || $año == 3) {
            $recursantes = Alumno::select('nombres', 'apellidos', 'id', 'comision_id')->whereHas('carreras', function ($query) use ($comision, $carrera_id, $año) {
                $query->where('carrera_id', $carrera_id)
                    ->where('año', ($año - 1))
                    ->where('ciclo_lectivo', $comision->ciclo_lectivo);
            });

            if ($año == 2 || $año == "2") {
                $recursantes = $recursantes->where('regularidad', '!=', 'regular_primero')->orderBy('apellidos')->get();
            } elseif ($año == 3 || $año == "3") {
                $recursantes = $recursantes->where('regularidad', '!=', 'regular_segundo')->orderBy('apellidos')->get();
            }
        }

        // dd($recursantes);
        return view('comision.detail', [
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
            'comision' => $comision_id,
            'ciclos_lectivos' => $this->cicloLectivoService->getCicloInicialYActual()
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

        $alumnos = Alumno::where('comision_id', $comision->id)->update([
            'comision_id' => null
        ]);
        $calificaciones = Calificacion::where('comision_id', $comision->id)->get();
        Calificacion::where('comision_id', $comision->id)->update([
            'comision_id' => null
        ]);


        if ($comision->profesores()) {
            $comision->profesores()->detach();
        }

        if ($comision->materias()) {
            $comision->materias()->detach();
        }

        if ($comision->alumnos()) {
            $comision->alumnos()->detach();
        }

        if ($comision->procesos()) {
            $comision->procesos()->detach();
        }

        $comision->delete();

        return redirect()->back()->with(
            'alert_warning',
            'La comisión se eliminó con exito!'
        );
    }

    public function agregar_profesor(Request $request, $id)
    {
        $comision = Comision::find($id);
        if (!$comision->hasProfesor($request['profesor_id'])) {
            $comision->profesores()->attach(User::where('id', $request['profesor_id'])->first());
            $mensaje = ['mensaje_success' => 'El profesor se ha añadido correctamente.'];
        } else {
            $mensaje = [
                'mensaje_error' => 'El profesor ya existe en esta comisión.'
            ];
        }

        return redirect()->route('comisiones.show', $comision->id)->with($mensaje);
    }

    public function delete_profesor(Request $request, $id)
    {
        $comision = Comision::find($id);

        if ($comision->hasProfesor($request['profesor_id'])) {
            $comision->profesores()->detach(User::where('id', $request['profesor_id'])->first());
            $mensaje = ['profesor_deleted' => 'El profesor se ha eliminado correctamente.'];
        }

        return redirect()->route('comisiones.show', $comision->id)->with($mensaje);
    }

    public function agregar_alumno(Request $request)
    {
        $comision = Comision::find($request['comision_id']);
        if ($request['todos'] == 'true') {
            $alumnos = Alumno::select('nombres', 'apellidos', 'id', 'comision_id')->whereHas('carreras', function ($query) use ($comision) {
                $query->where('carrera_id', $comision->carrera_id)
                    ->where('año', $comision->año)
                    ->where('ciclo_lectivo', $comision->ciclo_lectivo);
            })->get();

            foreach ($alumnos as $alumno) {
                $this->alumnoService->agregarComision($request, $alumno, $comision);
            }

            $mensaje = 'Alumnos asignados';
        } else {
            $alumno = Alumno::find($request['alumno_id']);

            $this->alumnoService->agregarComision($request, $alumno, $comision);
            $mensaje = $alumno->id . ' alumno asignado';
        }

        return response()->json($mensaje, 200);
    }
}
