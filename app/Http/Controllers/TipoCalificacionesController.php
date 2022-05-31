<?php

namespace App\Http\Controllers;

use App\Models\TipoCalificaciones;
use App\Request\TipoCalificacionesRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TipoCalificacionesController extends Controller
{

    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente');
    }

    /**
     * Display a listing of the resources TipoCalificaciones.
     */
    public function index()
    {
        $tipoCalificaciones = TipoCalificaciones::all();

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
     * @param TipoCalificacionesRequest $request
     * @return RedirectResponse
     */
    public function store(TipoCalificacionesRequest $request): RedirectResponse
    {
        $tipoCalificacion = TipoCalificaciones::create($request->validated());
        session()->flash(
            'success',
            "El nuevo tipo de calificación {$tipoCalificacion->nombre} con descripción {$tipoCalificacion->descripcion} fue creado"
        );

        return redirect()
            ->route('tipoCalificaciones.index')
            ->withSuccess("El nuevo tipo de calificación {$tipoCalificacion->nombre} con descripción {$tipoCalificacion->descripcion} fue creado");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TipoCalificaciones $tipoCalificacione
     * @return RedirectResponse
     */
    public function destroy(TipoCalificaciones $tipoCalificacione):RedirectResponse
    {
        $tipoCalificacione->delete();

        return redirect()->route('tipoCalificaciones.index')
            ->withSuccess(
                "El tipo calificación  {$tipoCalificacione->descripcion} con nombre {$tipoCalificacione->nombre} fue borrado correctamente"
            );
    }
}
