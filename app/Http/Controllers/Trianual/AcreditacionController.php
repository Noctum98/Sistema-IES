<?php

namespace App\Http\Controllers\Trianual;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trianual\StoreAcreditacionRequest;
use App\Http\Requests\Trianual\UpdateAcreditacionRequest;
use App\Models\Trianual\Acreditacion;

class AcreditacionController extends Controller
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
     * @param  \App\Http\Requests\Trianual\StoreAcreditacionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAcreditacionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trianual\Acreditacion  $acreditacion
     * @return \Illuminate\Http\Response
     */
    public function show(Acreditacion $acreditacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trianual\Acreditacion  $acreditacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Acreditacion $acreditacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Trianual\UpdateAcreditacionRequest  $request
     * @param  \App\Models\Trianual\Acreditacion  $acreditacion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAcreditacionRequest $request, Acreditacion $acreditacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trianual\Acreditacion  $acreditacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acreditacion $acreditacion)
    {
        //
    }
}
