<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\User;
use App\Models\Carrera;

use Illuminate\Http\Request;

class UserCargoController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.roles:admin-coordinador');
    }

    public function store(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $carrera = Carrera::find($request['carrera']);
        $cargo = Cargo::find($request['cargo']);

        if ($user->hasSede($carrera->sede_id)) {
            if (!$user->hasCarrera($carrera->id)) {
                $user->carreras()->attach($carrera);
            }

            if ($user->hasCargo($cargo->id)) {
                return redirect()->route('usuarios.admin')->with(
                    ['error_materia' => 'El usuario ya tiene asignado este cargo.']
                );
            } else {
                $user->cargos()->attach($cargo);
            }
        } else {
            return redirect()->route('usuarios.admin')->with(['error_sede' => 'El usuario no pertenece a esa sede']);
        }

        return redirect()->route('usuarios.admin')->with(
            ['carrera_success' => 'Se han añadido el cargo y carrera al usuario']
        );
    }

    public function delete($id, $cargo_id)
    {
        $user = User::find($id);
        $user->cargos()->detach(Cargo::where('id', $cargo_id)->first());

        return redirect()->route('usuarios.detalle', [
            'id' => $user->id,
        ]);
    }
}
