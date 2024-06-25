<?php

namespace App\Http\Controllers;

use App\Models\LibroPapel;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\View\View;

class LibroPapelController extends Controller
{

    /**
     * Display a listing of the libro papel.
     *
     * @return View
     */
    public function index()
    {
        $sedes = $this->getSedes();


        $librosPapel = LibroPapel::with(
            'sede',
            'user')
            ->whereIn('sede_id',$sedes )
            ->paginate(25);

        return view('libro_papel.index', compact('librosPapel'));
    }

    /**
     * Show the form for creating a new libro papel.
     *
     * @return View
     */
    public function create()
    {
        $sedes = $this->getSedes(true);

        return view('libro_papel.create', compact('sedes'));
    }

    /**
     * Store a new libro papel in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        if (empty($data['acta_inicio'])) {
            $data['acta_inicio'] = null;
        }
        if (empty($data['operador_inicio'])) {
            $data['operador_inicio'] = null;
        }
        if (empty($data['fecha_inicio'])) {
            $data['fecha_inicio'] = null;
        }

        $user = auth()->user();
        $data['user_id'] = $user->id;

        LibroPapel::create($data);

        return redirect()->route('libro_papel.libro_papel.index')
            ->with('success_message', 'Libro Papel ha sido guardado correctamente.');
    }

    /**
     * Display the specified libro papel.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $libroPapel = LibroPapel::with('sede', 'user')->findOrFail($id);

        return view('libro_papel.show', compact('libroPapel'));
    }

    /**
     * Show the form for editing the specified libro papel.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $libroPapel = LibroPapel::findOrFail($id);
        $sedes = $this->getSedes(true);

        return view('libro_papel.edit', compact('libroPapel', 'sedes'));
    }

    /**
     * Update the specified libro papel in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $libroPapel = LibroPapel::findOrFail($id);
        $libroPapel->update($data);

        return redirect()->route('libro_papel.libro_papel.index')
            ->with('success_message', 'Libro Papel ha sido actualizado correctamente.');
    }

    /**
     * Remove the specified libro papel from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $libroPapel = LibroPapel::findOrFail($id);
            $libroPapel->delete();

            return redirect()->route('libro_papel.libro_papel.index')
                ->with('success_message', 'Libro Papel ha sido eliminado correctamente.');
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
            'name' => 'required|string|min:1|max:191',
            'number' => 'required|numeric|min:0|max:4294967295',
            'roman' => 'required|string|min:1|max:191',
            'acta_inicio' => 'nullable|string',
            'operador_inicio' => 'nullable|string',
            'fecha_inicio' => 'nullable|string',
            'sede_id' => 'required',
        ];

        return $request->validate($rules);
    }



}
