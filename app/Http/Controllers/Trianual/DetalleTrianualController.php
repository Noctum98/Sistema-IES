<?php

namespace App\Http\Controllers\Trianual;

use App\Http\Requests\Trianual\StoreDetalleTrianualRequest;
use App\Http\Requests\Trianual\UpdateDetalleTrianualRequest;
use App\Models\Trianual\DetalleTrianual;
use App\Models\Trianual\Trianual;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DetalleTrianualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request, Trianual $trianual)
    {

        return view('trianual.detalle.detail', [
            'trianual' => $trianual,
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
     * @param  \App\Http\Requests\Trianual\StoreDetalleTrianualRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetalleTrianualRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetalleTrianual  $detalleTrianual
     * @return \Illuminate\Http\Response
     */
    public function show(DetalleTrianual $detalleTrianual)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetalleTrianual  $detalleTrianual
     * @return \Illuminate\Http\Response
     */
    public function edit(DetalleTrianual $detalleTrianual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Trianual\UpdateDetalleTrianualRequest  $request
     * @param  \App\Models\DetalleTrianual  $detalleTrianual
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetalleTrianualRequest $request, DetalleTrianual $detalleTrianual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetalleTrianual  $detalleTrianual
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetalleTrianual $detalleTrianual)
    {
        //
    }
}
