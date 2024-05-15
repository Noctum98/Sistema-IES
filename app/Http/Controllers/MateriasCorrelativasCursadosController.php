<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CondicionCarrera;
use App\Models\Materia;
use App\Models\MateriasCorrelativasCursado;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class MateriasCorrelativasCursadosController extends Controller
{

    /**
     * Display a listing of the materias correlativas cursados.
     *
     * @return View
     */
    public function index()
    {
        $materiasCorrelativasCursados = MateriasCorrelativasCursado::paginate(15)->withQueryString();

        return view('materias_correlativas_cursados.index', compact('materiasCorrelativasCursados'));
    }

    /**
     * Show the form for creating a new materias correlativas cursado.
     *
     * @return View
     */
    public function create()
    {
        $Materias = Materia::pluck('correlativa', 'id')->all();
        $Users = User::pluck('username', 'id')->all();

        return view('materias_correlativas_cursados.create', compact('Materias', 'Materias', 'Users'));
    }

    /**
     * Store a new materias correlativas cursado in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        MateriasCorrelativasCursado::create($data);

        return redirect()->route('materias_correlativas_cursados.materias_correlativas_cursado.index')
            ->with('success_message', 'Materias Correlativas Cursado fue agregado exitosamente.');
    }

    /**
     * Display the specified materias correlativas cursado.
     *
     * @param int $id
     *
     * @return View
     */
    public function show(int $id)
    {
        $materiasCorrelativasCursado = MateriasCorrelativasCursado::with('materia', 'materia', 'user')->findOrFail($id);

        return view('materias_correlativas_cursados.show', compact('materiasCorrelativasCursado'));
    }

    /**
     * Show the form for editing the specified materias correlativas cursado.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit(int $id)
    {
        $materiasCorrelativasCursado = MateriasCorrelativasCursado::findOrFail($id);
        $Materias = Materia::pluck('correlativa', 'id')->all();
        $Users = User::pluck('username', 'id')->all();

        return view('materias_correlativas_cursados.edit', compact('materiasCorrelativasCursado', 'Materias', 'Materias', 'Users'));
    }

    /**
     * Update the specified materias correlativas cursado in the storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(int $id, Request $request)
    {

        $data = $this->getData($request);

        $materiasCorrelativasCursado = MateriasCorrelativasCursado::findOrFail($id);
        $materiasCorrelativasCursado->update($data);

        return redirect()->route('materias_correlativas_cursados.materias_correlativas_cursado.index')
            ->with('success_message', 'Materias Correlativas Cursado fue actualizado exitosamente.');
    }

    /**
     * Remove the specified materias correlativas cursado from the storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $materiasCorrelativasCursado = MateriasCorrelativasCursado::findOrFail($id);
            $materiasCorrelativasCursado->delete();

            return redirect()->route('materias_correlativas_cursados.materias_correlativas_cursado.index')
                ->with('success_message', 'Materias Correlativas Cursado was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
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
            'materia_id' => 'required',
            'previa_id' => 'required',
            'operador_id' => 'required',
        ];

        return $request->validate($rules);
    }

}
