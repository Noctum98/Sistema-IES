<?php

namespace App\Http\Controllers;


use App\Models\LibroDigital;
use App\Models\LibroPapel;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Models\User;
use App\Repository\Sede\SedeRepository;
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
        $sedes = $this->getSedes();

        $librosDigitales = LibroDigital::with(
            'sede',
            'user')
            ->whereIn('sede_id', $sedes)
            ->paginate(25);


        return view('libros_digitales.index', compact('librosDigitales'));
    }

    /**
     * Display a listing of the libros digitales.
     *
     * @param Request $request
     * @return View
     */
    public function indexSede(Request $request): View
    {
        $sedes = $this->getSedes(true);

        $sede_id = $request->has('sede_id') ?$request->get('sede_id'): reset($sedes);

        $sede = Sede::where('nombre', $sede_id)->get()->pluck('id')->toArray();

        $librosDigitales = LibroDigital::with(
            'sede',
        )
            ->whereIn('sede_id', $sede)
            ->orderBy('sede_id')
            ->orderBy('resoluciones_id')
            ->orderBy('number')
            ->paginate(25);


        return view('libros_digitales.index_sede', compact('librosDigitales', 'sedes', 'sede_id'));
    }

    /**
     * Show the form for creating a new libros digitales.
     *
     * @return View
     */
    public function create()
    {
        $Sedes = $this->getSedes(true);
        $sedesId = $this->getSedes();

        $sedeRepository = new SedeRepository;
        $Resoluciones = $sedeRepository->getResolucionesSedes($sedesId)->toArray();
        $LibrosPapel = $sedeRepository->getLibrosPapelSedes($sedesId);

        return view('libros_digitales.create', compact('Resoluciones', 'Sedes', 'LibrosPapel'));
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

        $user = auth()->user();
        $data['user_id'] = $user->id;

        LibroDigital::create($data);

        return redirect()->route('libros_digitales.libro_digital.index')
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
        $libroDigital = LibroDigital::findOrFail($id);

        $sedesId = $this->getSedes();
        $sedeRepository = new SedeRepository;
        $Resoluciones = $sedeRepository->getResolucionesSedes($sedesId)->toArray();
        $LibrosPapel = $sedeRepository->getLibrosPapelSedes($sedesId);


        $Sedes = $this->getSedes(true);


        return view('libros_digitales.edit', compact('libroDigital', 'Resoluciones', 'Sedes', 'LibrosPapel'));
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

        return redirect()->route('libros_digitales.libro_digital.index')
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

            'number' => 'required|numeric|min:0|max:4294967295',
            'romanos' => 'required|string|min:1|max:191',
            'resoluciones_id' => 'required',
            'fecha_inicio' => 'nullable|string|min:0',
            'sede_id' => 'required',
            'libro_papel_id' => 'nullable|exist:libro_papel,id',
            'operador_id' => 'nullable',
            'observaciones' => 'nullable|string|min:1|max:191',
        ];

        return $request->validate($rules);
    }

}
