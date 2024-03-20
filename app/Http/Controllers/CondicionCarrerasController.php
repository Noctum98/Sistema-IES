<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CondicionCarrera;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class CondicionCarrerasController extends Controller
{

    /**
     * Display a listing of the condicion carreras.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
//        $condicionCarreras = CondicionCarrera::with('nombre')->paginate(25);
        $condicionCarreras = CondicionCarrera::paginate(15)->withQueryString();;

        return view('condicion_carreras.index', compact('condicionCarreras'));
    }

    /**
     * Show the form for creating a new condicion carrera.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        return view('condicion_carreras.create');
    }

    /**
     * Store a new condicion carrera in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {


        $data = $this->getData($request);
        $user = Auth()->user();
        $data['operador_id'] = $user->id;

        CondicionCarrera::create($data);

        return redirect()->route('condicion_carreras.condicion_carrera.index')
            ->with('success_message', 'Condición Carrera fur guardada correctamente.');
    }

    /**
     * Display the specified condicion carrera.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $condicionCarrera = CondicionCarrera::with('user')->findOrFail($id);

        return view('condicion_carreras.show', compact('condicionCarrera'));
    }

    /**
     * Show the form for editing the specified condicion carrera.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $condicionCarrera = CondicionCarrera::findOrFail($id);
        $Users = User::pluck('username','id')->all();

        return view('condicion_carreras.edit', compact('condicionCarrera','Users'));
    }

    /**
     * Update the specified condicion carrera in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);

        $condicionCarrera = CondicionCarrera::findOrFail($id);
        $condicionCarrera->update($data);

        return redirect()->route('condicion_carreras.condicion_carrera.index')
            ->with('success_message', 'Condicion Carrera was successfully updated.');
    }

    /**
     * Remove the specified condicion carrera from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $condicionCarrera = CondicionCarrera::findOrFail($id);
            $condicionCarrera->delete();

            return redirect()->route('condicion_carreras.condicion_carrera.index')
                ->with('success_message', 'Condicion Carrera was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
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
                'nombre' => 'required|string|min:1|max:191',
            'identificador' => 'required|string|min:1|max:191',
            'habilitado' => 'boolean',
            'operador_id' => 'required',
        ];

        $data = $request->validate($rules);

        $data['habilitado'] = $request->has('habilitado');

        return $data;
    }

}
