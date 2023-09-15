<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCargoProcesoRequest;
use App\Http\Requests\UpdateCargoProcesoRequest;
use App\Models\CargoProceso;

class CargoProcesoController extends Controller
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
     * @param  \App\Http\Requests\StoreCargoProcesoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCargoProcesoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CargoProceso  $cargoProceso
     * @return \Illuminate\Http\Response
     */
    public function show(CargoProceso $cargoProceso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CargoProceso  $cargoProceso
     * @return \Illuminate\Http\Response
     */
    public function edit(CargoProceso $cargoProceso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCargoProcesoRequest  $request
     * @param  \App\Models\CargoProceso  $cargoProceso
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCargoProcesoRequest $request, CargoProceso $cargoProceso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CargoProceso  $cargoProceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(CargoProceso $cargoProceso)
    {
        //
    }
}
