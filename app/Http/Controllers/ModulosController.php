<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Materia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModulosController extends Controller
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

    public function ver_modulo(Materia $materia)
    {
        $cargos = Cargo::where([
           'carrera_id' => $materia->carrera_id
        ])->get();
        return view('modulos.ver', [
            'modulo' => $materia,
            'cargos' => $cargos
        ]);
    }

    public function agregarCargo(Request $request): RedirectResponse
    {
        $cargo = Cargo::find($request['cargo_id']);
        $cargo->materias()->attach(Materia::find($request['materia']));

        return redirect()->route('modulos.ver', $request['materia']);
    }

    public function asignaRelacionCargoModulo(Request $request)
    {

        $cargo_materia = CargoMateria::find($request['cargo_modulo_id']);

        if ($cargo_materia) {
            $cargo_materia->update(["carga_tfi" => $request['valor']]);

        }

        return view('modulos.ver', [
            'modulo' => $cargo_materia->materia_id
        ]);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function show(Materia $materia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit(Materia $materia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materia $materia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materia $materia)
    {
        //
    }
}
