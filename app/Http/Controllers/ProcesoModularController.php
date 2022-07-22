<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\ProcesoModular;
use App\Services\ProcesoModularService;
use Illuminate\Http\Request;

class ProcesoModularController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Materia $materia)
    {
        $seviceModular = new ProcesoModularService();
        dd($seviceModular->crearProcesoModular($materia->id));


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
     * @param  \App\Models\ProcesoModular  $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function show(ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProcesoModular  $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProcesoModular  $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProcesoModular  $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcesoModular $procesoModular)
    {
        //
    }
}
