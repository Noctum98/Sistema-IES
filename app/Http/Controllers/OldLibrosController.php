<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\OldLibro;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class OldLibrosController extends Controller
{

    /**
     * Display a listing of the old libros.
     *
     * @return View
     */
    public function index()
    {
        $oldLibrosObjects = OldLibro::paginate(25);

        return view('old_libros.index', compact('oldLibrosObjects'));
    }

    /**
     * Show the form for creating a new old libros.
     *
     * @return View
     */
    public function create()
    {
        $Resoluciones = Resoluciones::pluck('name', 'id')->all();
        $Sedes = Sede::pluck('nombre', 'id')->all();
        $Users = User::pluck('username', 'id')->all();

        return view('old_libros.create', compact('Resoluciones', 'Sedes', 'Users', 'Users'));
    }

    /**
     * Store a new old libros in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        OldLibro::create($data);

        return redirect()->route('old_libros.old_libros.index')
            ->with('success_message', 'Libro (Maestro) agregado exitosamente.');
    }

    /**
     * Display the specified old libros.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $oldLibros = OldLibro::with('resoluciones', 'sede', 'user', 'user')->findOrFail($id);

        return view('old_libros.show', compact('oldLibros'));
    }

    /**
     * Show the form for editing the specified old libros.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $oldLibros = OldLibro::findOrFail($id);
        $Resoluciones = Resoluciones::pluck('name', 'id')->all();
        $Sedes = Sede::pluck('nombre', 'id')->all();
        $Users = User::pluck('username', 'id')->all();

        return view('old_libros.edit', compact('oldLibros', 'Resoluciones', 'Sedes', 'Users', 'Users'));
    }

    /**
     * Update the specified old libros in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $oldLibros = OldLibro::findOrFail($id);
        $oldLibros->update($data);

        return redirect()->route('old_libros.old_libros.index')
            ->with('success_message', 'Libro (Maestro) ha sido actualizado correctamente.');
    }

    /**
     * Remove the specified old libros from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $oldLibros = OldLibro::findOrFail($id);
            $oldLibros->delete();

            return redirect()->route('old_libros.old_libros.index')
                ->with('success_message', 'Libro (Maestro) ha sido correctamente eliminado.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ha sucedido un error mientras procesaba su petición.']);
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
            'acta_inicio' => 'nullable',
            'number' => 'required|numeric|min:0|max:4294967295',
            'romanos' => 'required|string|min:1|max:191',
            'resoluciones_id' => 'required',
            'fecha_inicio' => 'nullable|string|min:0',
            'sede_id' => 'required',
            'resolucion_original' => 'nullable|string|min:0|max:191',
            'operador_id' => 'nullable',
            'observaciones' => 'required|string|min:1|max:191',
            'user_id' => 'required',
        ];

        return $request->validate($rules);
    }

}
