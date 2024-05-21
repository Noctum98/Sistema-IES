<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarrerasRequest;
use App\Models\CondicionCarrera;
use App\Models\Resoluciones;
use Illuminate\Http\Request;
use App\Models\Sede;
use App\Models\Carrera;
use App\Services\UserService;

class CarreraController extends Controller
{
    protected UserService $userService;

    function __construct(UserService $userService)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente-areaSocial');
        $this->userService = $userService;
    }

    // Vistas

    public function vista_admin()
    {
        list($user, $carreras) = $this->userService->getCarreras();

        return view('carrera.admin', [
            'carreras' => $carreras,
            'user' => $user
        ]);
    }

    public function vista_crear()
    {
        $sedes = Sede::all();
        $condicionesCarrera = CondicionCarrera::all();
        $resoluciones = Resoluciones::all();
        return view('carrera.create', [
            'sedes' => $sedes,
            'condicionesCarrera' => $condicionesCarrera,
            'resoluciones' => $resoluciones
        ]);
    }

    public function vista_agregarPersonal(int $id)
    {
        $carrera = Carrera::find($id);

        return view('carrera.add_personal', [
            'carrera' => $carrera
        ]);
    }

    public function vista_editar(int $id)
    {
        $carrera = Carrera::find($id);
        $sedes = Sede::all();
        $condicionesCarrera = CondicionCarrera::all();
        $resoluciones = Resoluciones::all();


        return view('carrera.edit', [
            'carrera' => $carrera,
            'sedes' => $sedes,
            'condicionesCarrera' => $condicionesCarrera,
            'resoluciones' => $resoluciones
        ]);
    }

    // Funcionalidades
    public function crear(CarrerasRequest $request)
    {

        $request->validate([
            'sede_id' => 'required',
            'resolucion_id' => 'required'
        ]);

        $data = $request->all();

        $resoluciones = Resoluciones::find($data['resolucion_id']);

        $data['resolucion'] = $resoluciones->resolution;


        $carrera = Carrera::create($data);

        return redirect()->route('carrera.admin');
    }


    public function editar(int $id, CarrerasRequest $request)
    {

        $carrera = Carrera::find($id);
        $carrera->condicionCarrera()->associate($request->condicion_id);

        $resoluciones = Resoluciones::find($request->resolucion_id);

        $data = $request->all();

        $data['resolucion'] = $resoluciones->resolution;

        $carrera->update($data);


        return redirect()->route('carrera.editar', ['id' => $carrera->id])->with([
            'message' => 'Datos editados correctamente!'
        ]);
    }

    public function vistaCarrera(int $instancia)
    {
        $carrera = new Carrera();
        $carreras = $carrera->obtenerInstanciasCarrera($instancia);
        return view('mesa.components.vista_carreras')->with([
            'carreras' => $carreras,
            'instancia' => $instancia
        ]);
    }

    public function carrerasPorSedes(Request $request)
    {
        $carreras = Carrera::whereIn('sede_id', $request['sedes'])
            ->with('sede')
            ->orderBy('sede_id')
            ->get();

        return response()->json(['status' => 'success', 'data' => $carreras]);
    }

    protected function verProfesores($carrera_id)
    {
        $carrera = Carrera::find($carrera_id)->first();
        $profesores = $carrera->users()->get();
        return json_encode($profesores);
    }


}
