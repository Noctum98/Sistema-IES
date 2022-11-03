<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Sede;
use App\Models\Personal;
use App\Models\Carrera;
use Illuminate\Support\Facades\Auth;

class CarreraController extends Controller
{
    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente');
    }
    // Vistas

    public function vista_admin(){
        list($user, $carreras) = $this->getUserAndCarrera();

        $sedes = $user->sedes;
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
        $personal = Personal::where('sede_id',$carrera->sede_id)->get();

        return view('carrera.add_personal',[
            'personal' => $personal,
            'carrera'  => $carrera
        ]);
    }

    public function vista_editar(int $id){
        $carrera = Carrera::find($id);
        $personal = Personal::where('sede_id',$carrera->sede_id)->get();
        $sedes = Sede::all();

        return view('carrera.edit',[
            'carrera'   => $carrera,
            'sedes'     => $sedes,
            'personal'  => $personal
        ]);
    }

    // Funcionalidades
    public function crear(Request $request){
        $validate = $this->validate($request,[
            'sede_id'   =>  ['required','numeric'],
            'turno'     =>  ['required','string'],
            'nombre'    =>  ['required'],
            'titulo'    =>  ['required'],
            'años'      =>  ['required','numeric','max:4'],
            'modalidad' =>  ['required','alpha'],
            'vacunas'   =>  ['required','alpha']
        ]);

        $carrera = new Carrera();
        $carrera->sede_id = $request->input('sede_id');
        $carrera->nombre = $request->input('nombre');
        $carrera->titulo = $request->input('titulo');
        $carrera->años = $request->input('años');
        $carrera->modalidad = $request->input('modalidad');
        $carrera->resolucion = $request->input('resolucion');
        $carrera->turno = $request->input('turno');
        $carrera->vacunas = $request->input('vacunas');
        $carrera->save();

        return redirect()->route('carrera.personal',[
            'id'=>$carrera->id
        ]);
    }

    public function agregar_personal(int $id,Request $request){
        $carrera = Carrera::find($id);
        $carrera->coordinador = $request->input('coordinador');
        $carrera->referente_p = $request->input('referente_p');
        $carrera->referente_s = $request->input('referente_s');
        $carrera->update();

        return redirect()->route('carrera.admin')->with([
            'message'   =>  'La carrera ha sido creada correctamente'
        ]);

    }

    public function editar(int $id,Request $request){
        $validate = $this->validate($request,[
            'sede_id'   =>  ['required','numeric'],
            'nombre'    =>  ['required'],
            'titulo'    =>  ['required'],
            'años'      =>  ['required','numeric','max:4'],
            'modalidad' =>  ['required','alpha'],
            'vacunas'   =>  ['required','alpha']
        ]);
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

    /**
     * @return array
     */
    protected function getUserAndCarrera(): array
    {
        $user = Auth::user();
        $carreras = Carrera::orderBy('sede_id')->get();

        if (!$user->hasRole('admin') && !$user->hasRole('regente')) {
            $carreras = $user->carreras;
        }

        return array($user, $carreras);
    }

    protected function verProfesores($carrera_id)
    {
        $carrera = Carrera::find($carrera_id)->firtst();
            $profesores = $carrera->users()->get();
        dd(json_encode($profesores));
        return json_encode($profesores);
    }
}
