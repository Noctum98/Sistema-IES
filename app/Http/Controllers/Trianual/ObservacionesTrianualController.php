<?php

namespace App\Http\Controllers\Trianual;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trianual\StoreObservacionesTrianualRequest;
use App\Http\Requests\Trianual\UpdateObservacionesTrianualRequest;
use App\Models\Estados;
use App\Models\Trianual\ObservacionesTrianual;
use App\Models\Trianual\Trianual;
use App\Services\Trianual\DetalleTrianualService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ObservacionesTrianualController extends Controller
{
    private DetalleTrianualService $detalleTrianualService;

    /**
     * @param DetalleTrianualService $detalleTrianualService
     */
    public function __construct(DetalleTrianualService $detalleTrianualService)
    {
        $this->detalleTrianualService = $detalleTrianualService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param StoreObservacionesTrianualRequest $request
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function store(StoreObservacionesTrianualRequest $request): RedirectResponse
    {
        $data = $request->all();



        $trianual = Trianual::find($data['trianual_id']);

        $data['operador_id'] = Auth::user()->id;
        $data['observaciones'] = $data['observation'];

        $observacionesTrianual = ObservacionesTrianual::where([
            'year' => $data['year'],
            'trianual_id' => $trianual->id
        ])->first();
        $message = 'Observación ya creada';
        if (!$observacionesTrianual) {
            $observacionesTrianual = ObservacionesTrianual::create($data);

            $trianual->observacionesTrianuales()->save($observacionesTrianual);
            $message = 'Observación agregada con éxito';
        }

        Session::flash('message', $message);
        $estados = Estados::all();
        $detalles = $this->detalleTrianualService->detallesPorTrianual($trianual->id);

        return view('trianual.trianual.show', [
            'trianual' => $trianual,
            'estados' => $estados,
            'detalles' => $detalles
        ])->with([
            'message' => $message
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ObservacionesTrianual $observacionesTrianual
     * @return Response
     */
    public function show(ObservacionesTrianual $observacionesTrianual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ObservacionesTrianual $observacionesTrianual
     * @return Response
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
     * @return Response
     */
    public function update(UpdateObservacionesTrianualRequest $request, ObservacionesTrianual $observacionesTrianual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ObservacionesTrianual $observacionesTrianual
     * @return Response
     */
    public function destroy(ObservacionesTrianual $observacionesTrianual)
    {
        //
    }
}
