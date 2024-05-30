<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AgrupadaMateria;
use App\Models\CorrelatividadAgrupada;
use App\Models\MasterMateria;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AgrupadaMateriasController extends Controller
{

    /**
     * Display a listing of the agrupada materias.
     *
     * @return View
     */
    public function index()
    {
        $agrupadaMaterias = AgrupadaMateria::with('correlatividadagrupada', 'mastermateria', 'user')->paginate(25);

        return view('agrupada_materias.index', compact('agrupadaMaterias'));
    }

    /**
     * Show the form for creating a new agrupada materia.
     *
     * @return View
     */
    public function create()
    {
        $CorrelatividadAgrupadas = CorrelatividadAgrupada::pluck('Name', 'id')->all();
        $MasterMaterias = MasterMateria::pluck('name', 'id')->all();
        $users = User::pluck('activo', 'id')->all();

        return view('agrupada_materias.create', compact('CorrelatividadAgrupadas', 'MasterMaterias', 'users'));
    }

    /**
     * Store a new agrupada materia in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        AgrupadaMateria::create($data);

        return redirect()->route('agrupada_materias.agrupada_materia.index')
            ->with('success_message', 'Materia Agrupada correctamente agregada.');
    }

    /**
     * Display the specified agrupada materia.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $agrupadaMateria = AgrupadaMateria::with('correlatividadagrupada', 'mastermateria', 'user')->findOrFail($id);

        return view('agrupada_materias.show', compact('agrupadaMateria'));
    }

    /**
     * Show the form for editing the specified agrupada materia.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $agrupadaMateria = AgrupadaMateria::findOrFail($id);
        $CorrelatividadAgrupadas = CorrelatividadAgrupada::pluck('Name', 'id')->all();
        $MasterMaterias = MasterMateria::pluck('name', 'id')->all();
        $users = User::pluck('activo', 'id')->all();

        return view('agrupada_materias.edit', compact('agrupadaMateria', 'CorrelatividadAgrupadas', 'MasterMaterias', 'users'));
    }

    /**
     * Update the specified agrupada materia in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $agrupadaMateria = AgrupadaMateria::findOrFail($id);
        $agrupadaMateria->update($data);

        return redirect()->route('agrupada_materias.agrupada_materia.index')
            ->with('success_message', 'Materia agrupada correctamente actualizada.');
    }

    /**
     * Remove the specified agrupada materia from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $agrupadaMateria = AgrupadaMateria::findOrFail($id);
            $agrupadaMateria->delete();

            return redirect()->route('agrupada_materias.agrupada_materia.index')
                ->with('success_message', 'Materia agrupada correctamente eliminada.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ha ocurrido un error inesperado.' . $exception->getMessage()]);
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
            'correlatividad_agrupada_id' => 'required',
            'disabled' => 'boolean',
            'master_materia_id' => 'required',
            'user_id' => 'required',
        ];

        $data = $request->validate($rules);

        $data['disabled'] = $request->has('disabled');

        return $data;
    }

}
