<?php

namespace App\Http\Controllers\Parameters;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCicloLectivoEspecialRequest;
use App\Http\Requests\UpdateCicloLectivoEspecialRequest;
use App\Models\Materia;
use App\Models\Parameters\CicloLectivo;
use App\Models\Parameters\CicloLectivoEspecial;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CicloLectivoEspecialController extends Controller
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
     * @return Application|Factory|View
     */
    public function create(Materia $materia)
    {

        $ciclosLectivos = CicloLectivo::all();
        return view('parameters.ciclo_lectivo_especial.modal.form_agregar_ciclo_lectivo_especial')->with([
            'materia' => $materia,
            'ciclos_lectivos' => $ciclosLectivos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCicloLectivoEspecialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCicloLectivoEspecialRequest $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CicloLectivoEspecial  $cicloLectivoEspecial
     * @return \Illuminate\Http\Response
     */
    public function show(CicloLectivoEspecial $cicloLectivoEspecial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CicloLectivoEspecial  $cicloLectivoEspecial
     * @return \Illuminate\Http\Response
     */
    public function edit(CicloLectivoEspecial $cicloLectivoEspecial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCicloLectivoEspecialRequest  $request
     * @param  \App\Models\CicloLectivoEspecial  $cicloLectivoEspecial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCicloLectivoEspecialRequest $request, CicloLectivoEspecial $cicloLectivoEspecial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CicloLectivoEspecial  $cicloLectivoEspecial
     * @return \Illuminate\Http\Response
     */
    public function destroy(CicloLectivoEspecial $cicloLectivoEspecial)
    {
        //
    }
}
