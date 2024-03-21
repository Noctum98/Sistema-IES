<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CondicionCarrera;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CondicionCarrerasController extends Controller
{

    /**
     * Mostar un listing de condiciones carreras.
     *
     * @return View
     */
    public function index()
    {
        $condicionCarreras = CondicionCarrera::paginate(15)->withQueryString();;

        return view('condicion_carreras.index', compact('condicionCarreras'));
    }

    /**
     * Muestra el formulario de creación de una nueva condición carrera.
     *
     * @return View
     */
    public function create()
    {

        return view('condicion_carreras.create');
    }

    /**
     * Guarda una nueva condición carrera.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);


        CondicionCarrera::create($data);

        return redirect()->route('condicion_carreras.condicion_carrera.index')
            ->with('success_message', 'Condición Carrera fue guardada correctamente.');
    }

    /**
     * Mostrar una condición carrera en específico.
     *
     * @param int $id
     *
     * @return View
     */
    public function show(int $id): View
    {
        $condicionCarrera = CondicionCarrera::findOrFail($id);

        return view('condicion_carreras.show', compact('condicionCarrera'));
    }


    /**
     * Muestra el formulario de edición de una condición carrera específica.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit(int $id)
    {
        $condicionCarrera = CondicionCarrera::findOrFail($id);
        $Users = User::pluck('username', 'id')->all();

        return view('condicion_carreras.edit', compact('condicionCarrera', 'Users'));
    }

    /**
     * Actualizar una condición carrera específica.
     *
     * @param int $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(int $id, Request $request)
    {

        $data = $this->getData($request);

        $condicionCarrera = CondicionCarrera::findOrFail($id);
        $condicionCarrera->update($data);

        return redirect()->route('condicion_carreras.condicion_carrera.index')
            ->with('success_message', 'Condición Carrera ha sido actualizada correctamente.');
    }

    /**
     * Borra una condición carrera específica.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $condicionCarrera = CondicionCarrera::findOrFail($id);
            $condicionCarrera->delete();

            return redirect()->route('condicion_carreras.condicion_carrera.index')
                ->with('success_message', 'Condición Carrera correctamente borrada.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Se produjo un error inesperado al intentar procesar su solicitud.']);
        }
    }


    /**
     * Obtenga los datos de la request.
     *
     * @param Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|min:1|max:191',
            'identificador' => 'required|string|min:1|max:191',
            'habilitado' => 'boolean',
        ];

        $data = $request->validate($rules);

        $data['habilitado'] = $request->has('habilitado');
        $user = Auth()->user();
        $data['operador_id'] = $user->id;

        return $data;
    }

}
