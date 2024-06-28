<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoMateria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\View\View;

class TipoMateriasController extends Controller
{

    /**
     * Display a listing of the tipo materias.
     *
     * @return View
     */
    public function index()
    {
        $tipoMaterias = TipoMateria::paginate(25);

        return view('admin.tipo_materias.index', compact('tipoMaterias'));
    }

    /**
     * Show the form for creating a new tipo materia.
     *
     * @return View
     */
    public function create()
    {


        return view('admin.tipo_materias.create');
    }

    /**
     * Store a new tipo materia in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        TipoMateria::create($data);

        return redirect()->route('tipo_materias.tipo_materia.index')
            ->with('success_message', 'Tipo Materia ha sido correctamente agregado.');
    }

    /**
     * Display the specified tipo materia.
     *
     * @param int $id
     *
     * @return View
     */
    public function show(int $id)
    {
        $tipoMateria = TipoMateria::findOrFail($id);

        return view('admin.tipo_materias.show', compact('tipoMateria'));
    }

    /**
     * Show the form for editing the specified tipo materia.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit(int $id)
    {
        $tipoMateria = TipoMateria::findOrFail($id);


        return view('admin.tipo_materias.edit', compact('tipoMateria'));
    }

    /**
     * Update the specified tipo materia in the storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(int $id, Request $request)
    {

        $data = $this->getData($request);

        $tipoMateria = TipoMateria::findOrFail($id);
        $tipoMateria->update($data);

        return redirect()->route('tipo_materias.tipo_materia.index')
            ->with('success_message', 'Tipo Materia ha sido correctamente actualizado.');
    }

    /**
     * Remove the specified tipo materia from the storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $tipoMateria = TipoMateria::findOrFail($id);
            $tipoMateria->delete();

            return redirect()->route('tipo_materias.tipo_materia.index')
                ->with('success_message', 'Tipo Materia ha sido correctamente eliminado.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ha ocurrido un error inesperado mientras se procesaba su requerimiento.']);
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
                'identificador' => 'required|numeric|min:-2147483648|max:2147483647',
            'nombre' => 'required|string|min:1|max:191',
        ];

        return $request->validate($rules);
    }

}
