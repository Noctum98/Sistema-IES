<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Materia;
use App\Models\Sede;
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
        $cargo = Cargo::find($id);
        $sedes = Sede::all();

        return view('cargo.detail',[
            'cargo' => $cargo,
            'sedes' => $sedes
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
        $sedes = Sede::all();
        $cargo->materias()->attach(Materia::find($request['materia']));

        return redirect()->route('cargo.show',[
            'cargo' => $cargo,
            'sedes' => $sedes
        ]);

    }
}
