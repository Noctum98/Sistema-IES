<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarrerasRequest;
use App\Models\Cargo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Sede;
use App\Models\Personal;
use App\Models\Carrera;
use App\Services\CarreraService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CarreraController extends Controller
{
    protected $userService;
    function __construct(UserService $userService)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente-areaSocial');
        $this->userService = $userService;
    }
    // Vistas

    public function vista_admin(){
        list($user, $carreras) = $this->userService->getCarreras();

        return view('carrera.admin',[
            'carreras'  => $carreras
        ]);
    }

    public function vista_crear(){
        $sedes = Sede::all();
        return view('carrera.create',[
            'sedes' => $sedes
        ]);
    }

    public function vista_agregarPersonal(int $id){
        $carrera = Carrera::find($id);

        return view('carrera.add_personal',[
            'carrera'  => $carrera
        ]);
    }

    public function vista_editar(int $id){
        $carrera = Carrera::find($id);
        $sedes = Sede::all();

        return view('carrera.edit',[
            'carrera'   => $carrera,
            'sedes'     => $sedes,
        ]);
    }

    // Funcionalidades
    public function crear(CarrerasRequest $request){

        $carrera = Carrera::create($request->all());

        return redirect()->route('carrera.personal',[
            'id'=>$carrera->id
        ]);
    }


    public function editar(int $id,CarrerasRequest $request){
        $carrera = Carrera::find($id);
        $carrera->update($request->all());
        
        return redirect()->route('carrera.editar',['id'=>$carrera->id])->with([
            'message'   =>      'Datos editados correctamente!'
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

    protected function verProfesores($carrera_id)
    {
        $carrera = Carrera::find($carrera_id)->first();
            $profesores = $carrera->users()->get();
        return json_encode($profesores);
    }
}
