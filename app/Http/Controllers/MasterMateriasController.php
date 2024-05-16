<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterMateria;
use App\Models\Regimen;
use App\Models\Resolucione;
use Illuminate\Http\Request;
use Exception;

class MasterMateriasController extends Controller
{

    /**
     * Display a listing of the master materias.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $masterMaterias = MasterMateria::with('resolucione','regimen')->paginate(25);

        return view('master_materias.index', compact('masterMaterias'));
    }

    /**
     * Show the form for creating a new master materia.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $Resoluciones = Resolucione::pluck('name','id')->all();
$Regimens = Regimen::pluck('name','id')->all();

        return view('master_materias.create', compact('Resoluciones','Regimens'));
    }

    /**
     * Store a new master materia in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        MasterMateria::create($data);

        return redirect()->route('master_materias.master_materia.index')
            ->with('success_message', 'Master Materia fue agregado exitosamente.');
    }

    /**
     * Display the specified master materia.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $masterMateria = MasterMateria::with('resolucione','regimen')->findOrFail($id);

        return view('master_materias.show', compact('masterMateria'));
    }

    /**
     * Show the form for editing the specified master materia.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $masterMateria = MasterMateria::findOrFail($id);
        $Resoluciones = Resolucione::pluck('name','id')->all();
$Regimens = Regimen::pluck('name','id')->all();

        return view('master_materias.edit', compact('masterMateria','Resoluciones','Regimens'));
    }

    /**
     * Update the specified master materia in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
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
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $masterMateria = MasterMateria::findOrFail($id);
            $masterMateria->delete();

            return redirect()->route('master_materias.master_materia.index')
                ->with('success_message', 'Master Materia was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Se produjo un error inesperado al intentar procesar su solicitud.']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'name' => 'required|string|min:1|max:191',
            'year' => 'required|numeric|min:0|max:4294967295',
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
