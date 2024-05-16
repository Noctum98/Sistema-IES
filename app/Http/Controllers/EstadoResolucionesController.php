<?php

namespace App\Http\Controllers;

use App\Models\EstadoResoluciones;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\View\View;

class EstadoResolucionesController extends Controller
{

    /**
     * Display a listing of the estado resoluciones.
     *
     * @return View
     */
    public function index()
    {
        $estadoResolucionesObjects = EstadoResoluciones::paginate(25);

        return view('estado_resoluciones.index', compact('estadoResolucionesObjects'));
    }

    /**
     * Show the form for creating a new estado resoluciones.
     *
     * @return View
     */
    public function create()
    {


        return view('estado_resoluciones.create');
    }

    /**
     * Store a new estado resoluciones in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        EstadoResoluciones::create($data);

        return redirect()->route('estado_resoluciones.estado_resoluciones.index')
            ->with('success_message', 'Estado Resoluciones fue agregado correctamente.');
    }

    /**
     * Display the specified estado resoluciones.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $estadoResoluciones = EstadoResoluciones::findOrFail($id);

        return view('estado_resoluciones.show', compact('estadoResoluciones'));
    }

    /**
     * Show the form for editing the specified estado resoluciones.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $estadoResoluciones = EstadoResoluciones::findOrFail($id);


        return view('estado_resoluciones.edit', compact('estadoResoluciones'));
    }

    /**
     * Update the specified estado resoluciones in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $estadoResoluciones = EstadoResoluciones::findOrFail($id);
        $estadoResoluciones->update($data);

        return redirect()->route('estado_resoluciones.estado_resoluciones.index')
            ->with('success_message', 'Estado Resoluciones fue correctamente actualizado.');
    }

    /**
     * Remove the specified estado resoluciones from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $estadoResoluciones = EstadoResoluciones::findOrFail($id);
            $estadoResoluciones->delete();

            return redirect()->route('estado_resoluciones.estado_resoluciones.index')
                ->with('success_message', 'Estado Resoluciones fue correctamente borrado.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Se produjo un error inesperado al intentar procesar su solicitud.']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'name' => 'required|string|min:1|max:191',
            'identifier' => 'required|string|min:1|max:191',
            'disabled' => 'boolean',
        ];

        $data = $request->validate($rules);

        $data['disabled'] = $request->has('disabled');

        return $data;
    }

}
