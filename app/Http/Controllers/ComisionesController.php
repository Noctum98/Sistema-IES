<?php

namespace App\Http\Controllers;

use App\Models\Comision;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComisionController extends Controller
{

    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente-coordinador');
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $tipoCalificaciones = Comision::all();

        return view('tipoCalificaciones.admin', [
            'tipoCalificaciones' => $tipoCalificaciones,
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
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
