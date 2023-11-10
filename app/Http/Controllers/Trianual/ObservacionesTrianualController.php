<?php

namespace App\Http\Controllers\Trianual;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trianual\StoreObservacionesTrianualRequest;
use App\Http\Requests\Trianual\UpdateObservacionesTrianualRequest;
use App\Models\Trianual\ObservacionesTrianual;
use Illuminate\Http\RedirectResponse;

class ObservacionesTrianualController extends Controller
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
     * @param StoreObservacionesTrianualRequest $request
     * @return RedirectResponse
     */
    public function store(StoreObservacionesTrianualRequest $request): RedirectResponse
    {
        $observations = ObservacionesTrianual::where([
            'trianual_id' => $request->get('trianual_id'),
            'year' => $request->get('year')
        ])->first();

        if ($observations) {
            $observations->update($request->all());
        } else {
            ObservacionesTrianual::create($request->all());
        }

        return redirect()->route('trianual.ver', [
            'trianual' => $request->get('trianual_id'),
        ])->with(['alert_success'=>'Observación guardada correctamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ObservacionesTrianual $observacionesTrianual
     * @return \Illuminate\Http\Response
     */
    public function show(ObservacionesTrianual $observacionesTrianual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ObservacionesTrianual $observacionesTrianual
     * @return \Illuminate\Http\Response
     */
    public function edit(ObservacionesTrianual $observacionesTrianual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Trianual\UpdateObservacionesTrianualRequest $request
     * @param \App\Models\ObservacionesTrianual $observacionesTrianual
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObservacionesTrianualRequest $request, ObservacionesTrianual $observacionesTrianual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ObservacionesTrianual $observacionesTrianual
     * @return \Illuminate\Http\Response
     */
    public function destroy(ObservacionesTrianual $observacionesTrianual)
    {
        //
    }
}
