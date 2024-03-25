<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CondicionMateria;
use App\Models\Operador;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CondicionMateriasController extends Controller
{

    /**
     * Muestra un listado de condiciones materia.
     *
     * @return View
     */
    public function index()
    {
        $condicionMaterias = CondicionMateria::paginate(15)->withQueryString();

        return view('condicion_materias.index', compact('condicionMaterias'));
    }

    /**
     *Muestra un formulario para crear nueva condición materia.
     *
     * @return View
     */
    public function create()
    {

        return view('condicion_materias.create');
    }

    /**
     * Guarda una nueva condición materia.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        CondicionMateria::create($data);

        return redirect()->route('condicion_materias.condicion_materia.index')
            ->with('success_message', 'Condición Materia creada correctamente.');
    }

    /**
     * Muestra una condición materia específica.
     *
     * @param int $id
     *
     * @return View
     */
    public function show(int $id)
    {
        $condicionMateria = CondicionMateria::findOrFail($id);

        return view('condicion_materias.show', compact('condicionMateria'));
    }

    /**
     * Muestra un formulario para editar una condición materia.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit(int $id)
    {
        $condicionMateria = CondicionMateria::findOrFail($id);
        $operadors = User::pluck('id', 'id')->all();

        return view('condicion_materias.edit', compact('condicionMateria', 'operadors'));
    }

    /**
     * Actualiza una condición materia específica.
     *
     * @param int $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(int $id, Request $request)
    {

        $data = $this->getData($request);

        $condicionMateria = CondicionMateria::findOrFail($id);
        $condicionMateria->update($data);

        return redirect()->route('condicion_materias.condicion_materia.index')
            ->with('success_message', 'Condición Materia actualizada correctamente.');
    }

    /**
     * Borra una condición materia especifíca.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $condicionMateria = CondicionMateria::findOrFail($id);
            $condicionMateria->delete();

            return redirect()->route('condicion_materias.condicion_materia.index')
                ->with('success_message', 'Condición Materia borrada correctamente.');
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
