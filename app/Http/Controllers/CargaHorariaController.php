<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCargaHorariaRequest;
use App\Http\Requests\UpdateCargaHorariaRequest;
use App\Models\CargaHoraria;
use App\Models\Personal;
use App\Models\User;

class CargaHorariaController extends Controller
{


    function __construct()
    {
        $this->middleware('app.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personal = User::usersPersonal();

        return view('cargaHoraria.listado', [
            'personal' => $personal
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
     * @param  \App\Http\Requests\StoreCargaHorariaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCargaHorariaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CargaHoraria  $cargaHoraria
     * @return \Illuminate\Http\Response
     */
    public function show(User $persona)
    {
        $cargaHoraria = CargaHoraria::where([
            'profesor_id' => $persona->id
        ])->first();

        dd($cargaHoraria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CargaHoraria  $cargaHoraria
     * @return \Illuminate\Http\Response
     */
    public function edit(CargaHoraria $cargaHoraria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCargaHorariaRequest  $request
     * @param  \App\Models\CargaHoraria  $cargaHoraria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCargaHorariaRequest $request, CargaHoraria $cargaHoraria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CargaHoraria  $cargaHoraria
     * @return \Illuminate\Http\Response
     */
    public function destroy(CargaHoraria $cargaHoraria)
    {
        //
    }
}
