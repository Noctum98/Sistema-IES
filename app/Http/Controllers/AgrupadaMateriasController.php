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
use Illuminate\Support\Facades\Auth;
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

        return view('agrupada_materias.create', compact('CorrelatividadAgrupadas', 'MasterMaterias'));
    }

    /**
     * Show the form for creating a new agrupada materia.
     *
     * @return View
     */
    public function createGroup(CorrelatividadAgrupada $correlatividadAgrupada)
    {

        $MasterMaterias = MasterMateria::where('resoluciones_id', $correlatividadAgrupada->resoluciones_id)->get()->pluck('name', 'id')->all();

        return view('agrupada_materias.create_group', compact('correlatividadAgrupada', 'MasterMaterias'));
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
     * Store a new agrupada materia in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function storeGroup(Request $request)
    {
        $data = $this->getDataGroup($request);

        $this->addMateriasAgrupadas($data);

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
     * Show the form for editing the specified agrupada materia.
     *
     * @param CorrelatividadAgrupada $correlatividadAgrupada
     * @return View
     */
    public function editGroup(CorrelatividadAgrupada $correlatividadAgrupada)
    {

        $MasterMaterias = MasterMateria::where('resoluciones_id', $correlatividadAgrupada->resoluciones_id)->get()->pluck('name', 'id')->all();


        return view('agrupada_materias.edit_group', compact( 'correlatividadAgrupada', 'MasterMaterias'));
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
     * Update the specified agrupada materia in the storage.
     *
     * @param CorrelatividadAgrupada $correlatividadAgrupada
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function updateGroup(CorrelatividadAgrupada $correlatividadAgrupada, Request $request)
    {

        $data = $this->getDataGroup($request);
        foreach ($correlatividadAgrupada->agrupadaMaterias()->get() as $agrupada) {
            $agrupada->delete();
        }


        $this->addMateriasAgrupadas($data);


        return redirect()->route('correlatividad_agrupadas.correlatividad_agrupada.index')
            ->with('success_message', 'Materias Agrupadas correctamente agregadas.');
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

    /**
     * Get the request's data from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function getDataGroup(Request $request)
    {
        $rules = [
            'correlatividad_agrupada_id' => 'required',
            'master_materia_id' => 'required',
        ];

        return $request->validate($rules);
    }

    /**
     * @param array $data
     * @return void
     */
    public function addMateriasAgrupadas(array $data): void
    {
        $user = Auth::user()->id;
        $datos = [];
        $datos['user_id'] = $user;
        $datos['correlatividad_agrupada_id'] = $data['correlatividad_agrupada_id'];
        $datos['disabled'] = false;

        foreach ($data['master_materia_id'] as $master_materia_id) {
            $datos['master_materia_id'] = $master_materia_id;
            AgrupadaMateria::create($datos);
        }
    }

}
