<?php

namespace App\Http\Controllers;


use App\Models\LibroDigital;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\View\View;

class LibrosDigitalesController extends Controller
{

    /**
     * Display a listing of the libros digitales.
     *
     * @return View
     */
    public function index()
    {
        $librosDigitalesObjects = LibroDigital::paginate(25);

        return view('libros_digitales.index', compact('librosDigitalesObjects'));
    }

    /**
     * Show the form for creating a new libros digitales.
     *
     * @return View
     */
    public function create()
    {
        $Resoluciones = Resoluciones::pluck('name', 'id')->all();
        $Sedes = Sede::pluck('nombre', 'id')->all();
        $Users = User::pluck('username', 'id')->all();

        return view('libros_digitales.create', compact('Resoluciones', 'Sedes', 'Users', 'Users'));
    }

    /**
     * Store a new libros digitales in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        LibroDigital::create($data);

        return redirect()->route('libros_digitales.libros_digitales.index')
            ->with('success_message', 'Libro (Maestro) agregado exitosamente.');
    }

    /**
     * Display the specified libros digitales.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $librosDigitales = LibroDigital::with('resoluciones', 'sede', 'user', 'user')->findOrFail($id);

        return view('libros_digitales.show', compact('librosDigitales'));
    }

    /**
     * Show the form for editing the specified libros digitales.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $librosDigitales = LibroDigital::findOrFail($id);
        $Resoluciones = Resoluciones::pluck('name', 'id')->all();
        $Sedes = Sede::pluck('nombre', 'id')->all();
        $Users = User::pluck('username', 'id')->all();

        return view('libros_digitales.edit', compact('librosDigitales', 'Resoluciones', 'Sedes', 'Users', 'Users'));
    }

    /**
     * Update the specified libros digitales in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $librosDigitales = LibroDigital::findOrFail($id);
        $librosDigitales->update($data);

        return redirect()->route('libros_digitales.libros_digitales.index')
            ->with('success_message', 'Libro (Maestro) ha sido actualizado correctamente.');
    }

    /**
     * Remove the specified libros digitales from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $librosDigitales = LibroDigital::findOrFail($id);
            $librosDigitales->delete();

            return redirect()->route('libros_digitales.libros_digitales.index')
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
