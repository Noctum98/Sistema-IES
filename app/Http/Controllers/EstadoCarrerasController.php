<?php

namespace App\Http\Controllers;

use App\Models\EstadoCarrera;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\View\View;

class EstadoCarrerasController extends Controller
{

    /**
     * Display a listing of the estado carreras.
     *
     * @return View
     */
    public function index()
    {
        $estadoCarreras = EstadoCarrera::paginate(25);

        return view('estado_carreras.index', compact('estadoCarreras'));
    }

    /**
     * Show the form for creating a new estado carrera.
     *
     * @return View
     */
    public function create()
    {
        return view('estado_carreras.create');
    }

    /**
     * Store a new estado carrera in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        EstadoCarrera::create($data);

        return redirect()->route('estado_carreras.estado_carrera.index')
            ->with('success_message', 'Estado Carrera fue agregado correctamente.');
    }

    /**
     * Display the specified estado carrera.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $estadoCarrera = EstadoCarrera::findOrFail($id);

        return view('estado_carreras.show', compact('estadoCarrera'));
    }

    /**
     * Show the form for editing the specified estado carrera.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $estadoCarrera = EstadoCarrera::findOrFail($id);

        return view('estado_carreras.edit', compact('estadoCarrera'));
    }

    /**
     * Update the specified estado carrera in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $estadoCarrera = EstadoCarrera::findOrFail($id);
        $estadoCarrera->update($data);

        return redirect()->route('estado_carreras.estado_carrera.index')
            ->with('success_message', 'Estado Carrera fue correctamente actualizado.');
    }

    /**
     * Remove the specified estado carrera from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $estadoCarrera = EstadoCarrera::findOrFail($id);
            $estadoCarrera->delete();

            return redirect()->route('estado_carreras.estado_carrera.index')
                ->with('success_message', 'Estado Carrera fue correctamente eliminado.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ocurrió un error inesperado mientras se procesaba la solicitud.']);
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
