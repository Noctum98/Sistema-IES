<?php

namespace App\Http\Controllers\Parameters;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCicloLectivoRequest;
use App\Http\Requests\UpdateCicloLectivoRequest;
use App\Models\Parameters\CicloLectivo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class CicloLectivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $ciclos = CicloLectivo::all()->sortByDesc("year");

        return view('parameters.ciclo_lectivo.admin', [
            'ciclos' => $ciclos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCicloLectivoRequest $request
     * @return Response
     */
    public function store(StoreCicloLectivoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CicloLectivo $cicloLectivo
     * @return Response
     */
    public function show(CicloLectivo $cicloLectivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CicloLectivo $cicloLectivo
     * @return Application|Factory|View|Response
     */
    public function edit(CicloLectivo $cicloLectivo)
    {

        return view('parameters.ciclo_lectivo.modal.form_editar_ciclo_lectivo')->with([
            'cicloLectivo' => $cicloLectivo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCicloLectivoRequest $request
     * @param CicloLectivo $cicloLectivo
     * @return Application|Factory|View
     */
    public function update(UpdateCicloLectivoRequest $request, CicloLectivo $cicloLectivo)
    {
        $cicloLectivo->update($request->all());

        $ciclos = CicloLectivo::all()->sortByDesc("year");

        return view('parameters.ciclo_lectivo.admin', [
            'ciclos' => $ciclos,
        ]);

    }

    /**
     * Solo lista los ciclo lectivos especiales según el ciclo lectivo
     * @param CicloLectivo $cicloLectivo
     * @return void
     */
    public function especial(CicloLectivo $cicloLectivo)
    {
        dd($cicloLectivo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CicloLectivo $cicloLectivo
     * @return Response
     */
    public function destroy(CicloLectivo $cicloLectivo)
    {
        //
    }
}
