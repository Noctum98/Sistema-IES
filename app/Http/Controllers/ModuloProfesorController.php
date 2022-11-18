<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Materia;
use App\Models\ModuloProfesor;
use App\Models\Proceso;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModuloProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function agregarCargoModulo(Request $request): RedirectResponse
    {
        $modulos = ModuloProfesor::where([
            'user_id' => $request['usuario_id'],
        ]);

        $modulos = ModuloProfesor::select('modulo_profesor.*')
            ->join('cargo_materia', 'cargo_materia.id', 'modulo_profesor.modulo_id')
            ->where('cargo_materia.cargo_id', $request['cargo_id'])
            ->where('modulo_profesor.user_id', $request['usuario_id'])
            ->get();

        foreach ($modulos as $modulo) {
            $modulo->delete();
        }

        if (isset($request['materia_id'])) {
            foreach ($request['materia_id'] as $materia) {
                $cargo_modulo = CargoMateria::where([
                    'cargo_id' => $request['cargo_id'],
                    'materia_id' => $materia,
                ])->first();

                ModuloProfesor::create([
                    'user_id' => $request['usuario_id'],
                    'modulo_id' => $cargo_modulo->id,
                ]);
            }
        }

        return redirect()->route('cargo.show', $request['cargo_id']);
    }

    public function formAgregarCargoModulo(Cargo $cargo, User $usuario)
    {
        return view('cargo.modals.form_agregar_cargo_modulo')->with([
            'cargo' => $cargo,
            'usuario' => $usuario,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ModuloProfesor $moduloProfesor
     * @return \Illuminate\Http\Response
     */
    public function show(ModuloProfesor $moduloProfesor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ModuloProfesor $moduloProfesor
     * @return \Illuminate\Http\Response
     */
    public function edit(ModuloProfesor $moduloProfesor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ModuloProfesor $moduloProfesor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModuloProfesor $moduloProfesor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ModuloProfesor $moduloProfesor
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModuloProfesor $moduloProfesor)
    {
        //
    }
}
