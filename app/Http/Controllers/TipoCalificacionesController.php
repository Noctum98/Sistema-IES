<?php

namespace App\Http\Controllers;

use App\Models\TipoCalificaciones;
use App\Request\TipoCalificacionesRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
        // Ahora en modal
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
            ->withSuccess(
                "El nuevo tipo de calificación {$tipoCalificacion->nombre} con descripción {$tipoCalificacion->descripcion} fue creado"
            );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        // No usado
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TipoCalificaciones $tipoCalificacione
     * @return Application|Factory|View
     */
    public function edit(TipoCalificaciones $tipoCalificacione)
    {
        return view('tipoCalificaciones.modals.editar_tipo_calificacion')->with([
            'tipoCalificaciones' => $tipoCalificacione,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TipoCalificacionesRequest $request
     * @param TipoCalificaciones $tipoCalificacione
     * @return mixed
     */
    public function update(TipoCalificacionesRequest $request, TipoCalificaciones $tipoCalificacione)
    {
        $tipoCalificacione->update($request->validated());

        return redirect()
            ->route('tipoCalificaciones.index')
            ->withSuccess(
                "El tipo de calificación {$tipoCalificacione->nombre} con descripción {$tipoCalificacione->descripcion} fue actualizado correctamente"
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TipoCalificaciones $tipoCalificacione
     * @return RedirectResponse
     */
    public function destroy(TipoCalificaciones $tipoCalificacione): RedirectResponse
    {
        $tipoCalificacione->delete();

        return redirect()->route('tipoCalificaciones.index')
            ->withSuccess(
                "El tipo calificación  {$tipoCalificacione->descripcion} con nombre {$tipoCalificacione->nombre} fue borrado correctamente"
            );
    }
}
