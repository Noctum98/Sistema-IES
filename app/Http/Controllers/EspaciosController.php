<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEspaciosRequest;
use App\Http\Requests\UpdateEspaciosRequest;
use App\Models\Espacios;

class EspaciosController extends Controller
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
     * @param  \App\Http\Requests\StoreEspaciosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEspaciosRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Espacios  $espacios
     * @return \Illuminate\Http\Response
     */
    public function show(Espacios $espacios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Espacios  $espacios
     * @return \Illuminate\Http\Response
     */
    public function edit(Espacios $espacios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEspaciosRequest  $request
     * @param  \App\Models\Espacios  $espacios
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEspaciosRequest $request, Espacios $espacios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Espacios  $espacios
     * @return \Illuminate\Http\Response
     */
    public function destroy(Espacios $espacios)
    {
        //
    }
}
