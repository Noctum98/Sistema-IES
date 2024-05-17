<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoCarrera;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;

class TipoCarrerasController extends Controller
{

    /**
     * Display a listing of the tipo carreras.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tipoCarreras = TipoCarrera::paginate(25);

        return view('tipo_carreras.index', compact('tipoCarreras'));
    }

    /**
     * Show the form for creating a new tipo carrera.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        return view('tipo_carreras.create');
    }

    /**
     * Store a new tipo carrera in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        TipoCarrera::create($data);

        return redirect()->route('tipo_carreras.tipo_carrera.index')
            ->with('success_message', 'Tipo Carrera fue agregado exitosamente.');
    }

    /**
     * Display the specified tipo carrera.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $tipoCarrera = TipoCarrera::findOrFail($id);

        return view('tipo_carreras.show', compact('tipoCarrera'));
    }

    /**
     * Show the form for editing the specified tipo carrera.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tipoCarrera = TipoCarrera::findOrFail($id);


        return view('tipo_carreras.edit', compact('tipoCarrera'));
    }

    /**
     * Update the specified tipo carrera in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);

        $tipoCarrera = TipoCarrera::findOrFail($id);
        $tipoCarrera->update($data);

        return redirect()->route('tipo_carreras.tipo_carrera.index')
            ->with('success_message', 'Tipo Carrera fue actualizado exitosamente.');
    }

    /**
     * Remove the specified tipo carrera from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $tipoCarrera = TipoCarrera::findOrFail($id);
            $tipoCarrera->delete();

            return redirect()->route('tipo_carreras.tipo_carrera.index')
                ->with('success_message', 'Tipo Carrera was successfully deleted.');
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
            'description' => 'required|string|min:1|max:191',
            'identifier' => 'required|string|min:1|max:191',
        ];

        return $request->validate($rules);
    }

}
