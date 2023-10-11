<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCicloLectivoRequest;
use App\Http\Requests\UpdateCicloLectivoRequest;
use App\Models\CicloLectivo;

class CicloLectivoController extends Controller
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
     * @param  \App\Http\Requests\StoreCicloLectivoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCicloLectivoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CicloLectivo  $cicloLectivo
     * @return \Illuminate\Http\Response
     */
    public function show(CicloLectivo $cicloLectivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CicloLectivo  $cicloLectivo
     * @return \Illuminate\Http\Response
     */
    public function edit(CicloLectivo $cicloLectivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCicloLectivoRequest  $request
     * @param  \App\Models\CicloLectivo  $cicloLectivo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCicloLectivoRequest $request, CicloLectivo $cicloLectivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CicloLectivo  $cicloLectivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(CicloLectivo $cicloLectivo)
    {
        //
    }
}
