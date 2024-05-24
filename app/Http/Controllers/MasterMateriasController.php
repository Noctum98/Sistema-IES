<?php

namespace App\Http\Controllers;

use App\Models\MasterMateria;
use App\Models\Regimen;
use App\Models\Resoluciones;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\View\View;

class MasterMateriasController extends Controller
{

    /**
     * Display a listing of the master materias.
     *
     * @return View
     */
    public function index()
    {
        $masterMaterias = MasterMateria::with('resoluciones', 'regimen')->paginate(20);

        return view('master_materias.index', compact('masterMaterias'));
    }

    /**
     * Show the form for creating a new master materia.
     *
     * @return View
     */
    public function create()
    {
        $Resoluciones = Resoluciones::pluck('name', 'id')->all();
        $Regimens = Regimen::pluck('name', 'id')->all();

        return view('master_materias.create', compact('Resoluciones', 'Regimens'));
    }

    /**
     * Store a new master materia in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        MasterMateria::create($data);

        return redirect()->route('master_materias.master_materia.index')
            ->with('success_message', 'Materia fue agregado exitosamente al sistema.');
    }

    /**
     * Display the specified master materia.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $masterMateria = MasterMateria::with('resoluciones', 'regimen')->findOrFail($id);

        return view('master_materias.show', compact('masterMateria'));
    }

    /**
     * Show the form for editing the specified master materia.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $masterMateria = MasterMateria::findOrFail($id);
        $Resoluciones = Resoluciones::pluck('name', 'id')->all();
        $Regimens = Regimen::pluck('name', 'id')->all();

        return view('master_materias.edit', compact('masterMateria', 'Resoluciones', 'Regimens'));
    }

    /**
     * Update the specified master materia in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $masterMateria = MasterMateria::findOrFail($id);
        $masterMateria->update($data);

        return redirect()->route('master_materias.master_materia.index')
            ->with('success_message', 'Master Materia fue actualizado exitosamente.');
    }

    /**
     * Remove the specified master materia from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $masterMateria = MasterMateria::findOrFail($id);
            $masterMateria->delete();

            return redirect()->route('master_materias.master_materia.index')
                ->with('success_message', 'Master Materia fue correctamente eliminada.');
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
            'year' => 'required|numeric|min:1|max:6',
            'field_stage' => 'boolean|numeric',
            'delayed_closing' => 'boolean',
            'resoluciones_id' => 'required',
            'regimen_id' => 'required',
        ];

        $data = $request->validate($rules);

        $data['field_stage'] = $request->has('field_stage');
        $data['delayed_closing'] = $request->has('delayed_closing');

        return $data;
    }

}
