<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CargoController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador');
    }

    public function index()
    {
        $cargos = Cargo::all();
        $carreras = Carrera::all();

        return view('cargo.admin',[
            'cargos' => $cargos,
            'carreras' => $carreras
        ]);
    }

    public function show($id)
    {
        $users = User::whereHas('roles', function ($query) {
            return $query->where('nombre', 'profesor');
        })->get();

        $cargo = Cargo::find($id);
        $sedes = Sede::all();

        return view('cargo.detail',[
            'cargo' => $cargo,
            'sedes' => $sedes,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $this->getValidate($request);

        $cargo = Cargo::create($request->all());

        return redirect()->route('cargo.admin');
    }

    public function vista_editar(Cargo $id){
        $user = Auth::user();
        $carreras = $user->carreras;

        return view('cargo.edit',[
            'cargo'   => $id,
            'carreras'     => $carreras,
//            'personal'  => $personal
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function editar(Cargo $cargo,Request $request){
        $this->getValidate($request);


        $cargo->carrera_id = $request->input('carrera_id');
        $cargo->update($request->all());

        return redirect()->route('cargo.show',['id'=>$cargo->id])->with([
            'message'   =>      'Datos editados correctamente!'
        ]);
    }

    public function agregarModulo(Request $request)
    {
        $cargo = Cargo::find($request['cargo_id']);
        $cargo->materias()->attach(Materia::find($request['materia']));

        return redirect()->route('cargo.show',$cargo->id);
    }

    public function agregarUser(Request $request)
    {
        $cargo = Cargo::find($request['cargo_id']);

        $cargo->users()->attach(User::find($request['user_id']));

        return redirect()->route('cargo.show',$cargo->id);
    }

    public function selectCargos($id)
    {
        $cargos = Cargo::select('nombre','id')->where('carrera_id',$id)->get();
        return response()->json($cargos,200);
    }

    /**
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    protected function getValidate(Request $request): void
    {
        $validate = $this->validate($request, [
            'nombre' => ['required'],
            'carrera_id' => ['required', 'numeric'],
        ]);
    }

}
