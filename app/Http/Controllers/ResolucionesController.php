<?php

namespace App\Http\Controllers;

use App\Models\Estados;
use App\Models\Resoluciones;
use App\Models\TipoCarrera;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\View\View;

class ResolucionesController extends Controller
{

    /**
     * Display a listing of the resoluciones.
     *
     * @return View
     */
    public function index()
    {
        $resolucionesObjects = Resoluciones::with('tipocarrera', 'estado')->paginate(25);

        return view('resoluciones.index', compact('resolucionesObjects'));
    }

    /**
     * Show the form for creating a new resoluciones.
     *
     * @return View
     */
    public function create()
    {
        $TipoCarreras = TipoCarrera::pluck('name', 'id')->all();
        $estados = Estados::pluck('id', 'id')->all();

        return view('resoluciones.create', compact('TipoCarreras', 'estados'));
    }

    /**
     * Store a new resoluciones in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        Resoluciones::create($data);

        return redirect()->route('resoluciones.resoluciones.index')
            ->with('success_message', 'Resoluciones fue agregado exitosamente.');
    }

    /**
     * Display the specified resoluciones.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $resoluciones = Resoluciones::with('tipocarrera', 'estado')->findOrFail($id);

        return view('resoluciones.show', compact('resoluciones'));
    }

    /**
     * Show the form for editing the specified resoluciones.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $resoluciones = Resoluciones::findOrFail($id);
        $TipoCarreras = TipoCarrera::pluck('name', 'id')->all();
        $estados = Estados::pluck('id', 'id')->all();

        return view('resoluciones.edit', compact('resoluciones', 'TipoCarreras', 'estados'));
    }

    /**
     * Update the specified resoluciones in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $resoluciones = Resoluciones::findOrFail($id);
        $resoluciones->update($data);

        return redirect()->route('resoluciones.resoluciones.index')
            ->with('success_message', 'Resoluciones fue actualizado exitosamente.');
    }

    /**
     * Remove the specified resoluciones from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $resoluciones = Resoluciones::findOrFail($id);
            $resoluciones->delete();

            return redirect()->route('resoluciones.resoluciones.index')
                ->with('success_message', 'Resoluciones was successfully deleted.');
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
            'title' => 'required|string|min:1|max:191',
            'duration' => 'required|numeric|min:0|max:4294967295',
            'resolution' => 'required|string|min:1|max:191',
            'type' => 'required|string|min:1|max:191',
            'vaccines' => 'required|string|min:1|max:191',
            'tipo_carrera_id' => 'required',
            'estados_id' => 'required',
        ];

        return $request->validate($rules);
    }

}
