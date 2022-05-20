<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Materia;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin');
    }

    public function index()
    {
        $cargos = Cargo::all();

        return view('cargo.admin',[
            'cargos' => $cargos
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
        $validate = $this->validate($request,[
            'nombre' => ['required']
        ]);

        $cargo = Cargo::create($request->all());

        return redirect()->route('cargo.index');
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
//        $cargos = Cargo::select('nombre','id')->where('carrera_id',$id)->get();
        $cargos = Cargo::select('nombre','id')->get();




        return response()->json($cargos,200);
    }

}
