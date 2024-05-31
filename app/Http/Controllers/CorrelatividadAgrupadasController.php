<?php

namespace App\Http\Controllers;

use App\Models\CorrelatividadAgrupada;
use App\Models\Resoluciones;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CorrelatividadAgrupadasController extends Controller
{

    /**
     * Display a listing of the correlatividad agrupadas.
     *
     * @return View
     */
    public function index()
    {
        $correlatividadAgrupadas = CorrelatividadAgrupada::with('resoluciones', 'user')->paginate(25);

        return view('correlatividad_agrupadas.index', compact('correlatividadAgrupadas'));
    }

    /**
     * Show the form for creating a new correlatividad agrupada.
     *
     * @return View
     */
    public function create()
    {
        $Resoluciones = Resoluciones::pluck('name', 'id')->all();


        return view('correlatividad_agrupadas.create', compact('Resoluciones'));
    }

    /**
     * Store a new correlatividad agrupada in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);
        $user = Auth::user();
        $data['user_id'] = $user->id;

        CorrelatividadAgrupada::create($data);

        return redirect()->route('correlatividad_agrupadas.correlatividad_agrupada.index')
            ->with('success_message', 'Correlatividad Agrupada correctamente creada.');
    }

    /**
     * Display the specified correlatividad agrupada.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $correlatividadAgrupada = CorrelatividadAgrupada::with('resoluciones', 'user')->findOrFail($id);

        return view('correlatividad_agrupadas.show', compact('correlatividadAgrupada'));
    }

    /**
     * Show the form for editing the specified correlatividad agrupada.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $correlatividadAgrupada = CorrelatividadAgrupada::findOrFail($id);
        $Resoluciones = Resoluciones::pluck('name', 'id')->all();

        return view('correlatividad_agrupadas.edit', compact('correlatividadAgrupada', 'Resoluciones'));
    }

    /**
     * Update the specified correlatividad agrupada in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $user = Auth::user();
        $data['user_id'] = $user->id;


        $correlatividadAgrupada = CorrelatividadAgrupada::findOrFail($id);
        $correlatividadAgrupada->update($data);

        return redirect()->route('correlatividad_agrupadas.correlatividad_agrupada.index')
            ->with('success_message', 'Correlatividad Agrupada correctamente actualizada.');
    }

    /**
     * Remove the specified correlatividad agrupada from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $correlatividadAgrupada = CorrelatividadAgrupada::findOrFail($id);
            $correlatividadAgrupada->delete();

            return redirect()->route('correlatividad_agrupadas.correlatividad_agrupada.index')
                ->with('success_message', 'Correlatividad Agrupada correctamente eliminada.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ha ocurrido un error inesperado. ' . $exception->getMessage()]);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function getData(Request $request): array
    {
        $rules = [
            'description' => 'required|string|min:1|max:191',
            'disabled' => 'boolean',
            'identifier' => 'required|string|min:1|max:191',
            'name' => 'required|string|min:1|max:191',
            'resoluciones_id' => 'required',
            'cantidad_min' => 'required|integer|between:1,15',
        ];

        $data = $request->validate($rules);

        $data['identifier'] = strtolower($data['identifier']);
        $data['identifier'] = str_replace(' ', '_', $data['identifier']);

        if (!isset($data['disabled'])) {
            $data['disabled'] = false;
        }

        return $data;
    }

}
