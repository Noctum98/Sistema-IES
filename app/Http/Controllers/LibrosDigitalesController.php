<?php

namespace App\Http\Controllers;


use App\Handler\GenericHandler;
use App\Models\Libro;
use App\Models\LibroDigital;
use App\Models\MesaFolio;
use App\Models\Sede;
use App\Repository\Carrera\CarreraRepository;
use App\Repository\LibroDigital\LibroDigitalRepository;
use App\Repository\Sede\SedeRepository;
use App\Services\Trianual\LibroDigitalService;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LibrosDigitalesController extends Controller
{

    private GenericHandler $handler;
    private LibroDigitalService $libroDigitalService;

    /**
     * @param GenericHandler $handler
     * @param LibroDigitalService $libroDigitalService
     */
    public function __construct(GenericHandler $handler, LibroDigitalService $libroDigitalService)
    {
        $this->handler = $handler;
        $this->libroDigitalService = $libroDigitalService;
    }

    /**
     * Display a listing of the libros digitales.
     *
     * @return View
     */
    public function index(): View
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
    public function search(Request $request): View
    {
        $sedes = $this->getSedes(true);

        $sede_id = $request->has('sede_id') ? $request->get('sede_id') : reset($sedes);

        $sede = Sede::where('nombre', $sede_id)->get()->pluck('id')->toArray();

        $librosDigitales = LibroDigital::with(
            'sede',
        )
            ->whereIn('sede_id', $sede)
            ->orderBy('sede_id')
            ->orderBy('resoluciones_id')
            ->orderBy('number')
            ->paginate(25);


        return view('libros_digitales.search', compact('librosDigitales', 'sedes', 'sede_id'));
    }

    /**
     * Display a listing of the libros digitales.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function searchSede(Request $request)
    {
        $sede_id = $request->has('sede_id') ? $request->get('sede_id'):null;
        if(!$sede_id){
            return redirect()->route('libros_digitales.libro_digital.search')->with('alert_danger', 'No se encontró la sede');
        }

        $sede = Sede::where('nombre', $sede_id)->get()->pluck('id')->toArray();

        $librosDigitales = LibroDigital::with(
            'sede',
        )
            ->whereIn('sede_id', $sede)
            ->orderBy('sede_id')
            ->orderBy('resoluciones_id')
            ->orderBy('number')
            ->paginate(25);


        return view('libros_digitales.searchSede', compact('librosDigitales', 'sedes', 'sede_id'));
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

        $sede_id = $request->has('sede_id') ? $request->get('sede_id') : reset($sedes);

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
     * Display a listing of the libros digitales for carrera.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse|View
     */
    public function indexCarrera(Request $request)
    {
        $sedes = $this->getSedes();
        $sede = $request->get('sede');

        if (!in_array((int)$sede, $sedes, true)) {
            return redirect()->route('libros_digitales.libro_digital.index_sede')
                ->with('alert_danger', 'No tiene la sede asignada.');
        }

        $resolution_id = $request->get('resolution');

        $carreraRepository = new CarreraRepository();
        $resolutions = $carreraRepository->getResolucionesBySede($sede);

        $librosRepository = new LibroDigitalRepository();

        $librosDigitales = $librosRepository->getLibrosBySedeResolution($sede, $resolution_id);


        return view('libros_digitales.index_carrera',
            compact('librosDigitales', 'sedes', 'resolutions', 'sede', 'resolution_id'));
    }

    /**
     * Show the form for creating a new libros digitales.
     *
     * @return View
     */
    public function create(): View
    {
        $Sedes = $this->getSedes(true);
        $sedesId = $this->getSedes();

        $sedeRepository = new SedeRepository;
        $Resoluciones = $sedeRepository->getResolucionesSedes($sedesId)->toArray();
        $LibrosPapel = $sedeRepository->getLibrosPapelSedes($sedesId);

        return view('libros_digitales.create', compact('Resoluciones', 'Sedes', 'LibrosPapel'));
    }

    /**
     * Show the form for creating a new libros digitales.
     *
     * @param Sede $sede_id
     * @return View
     */
    public function createBySede(Sede $sede_id): View
    {

        $Sede = $sede_id;

        $sedeRepository = new SedeRepository;
        $Resoluciones = $sedeRepository->getResolucionesSedes([$Sede->id])->toArray();
        $LibrosPapel = $sedeRepository->getLibrosPapelSedes([$Sede->id]);

        return view('libros_digitales.create_sede', compact('Resoluciones', 'Sede', 'LibrosPapel'));
    }

    /**
     * Store a new libros digitales in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {

        $data = $this->getData($request);
        $data['romanos'] = $this->handler->convertirNumberToRoman($data['number']);

        $user = auth()->user();
        $data['user_id'] = $user->id;

        $librosDigital = LibroDigital::where([
            'sede_id' => $data['sede_id'],
            'resoluciones_id' => $data['resoluciones_id'],
            'number' => $data['number']
        ]);

        if ($librosDigital->exists()) {
            return redirect()->back()
                ->with('alert_danger', 'Libro Digital ya existe.');
        }


        LibroDigital::create($data);

        return redirect()->route('libros_digitales.libro_digital.index_sede')
            ->with('success_message', 'Libro (Maestro) agregado exitosamente.');
    }

    /**
     * Display the specified libros digitales.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id): View
    {
        $libroDigital = LibroDigital::with('resoluciones', 'sede', 'user', 'user')->findOrFail($id);

        return view('libros_digitales.show', compact('libroDigital'));
    }

    /**
     * Display the specified libros digitales.
     *
     * @param string $id
     *
     * @return View
     */
    public function showFolios(string $id): View
    {
        $libroDigital = LibroDigital::with('resoluciones', 'sede', 'user', 'user')->findOrFail($id);


        $folios = MesaFolio::with(
            'user', 'libroDigital', 'masterMateria', 'mesa'
        )
            ->where('libro_digital_id', $id)
            ->orderBy('folio')
            ->paginate(1);


        return view('libros_digitales.showFolios', compact('libroDigital', 'folios'));
    }

    /**
     * Show the form for editing the specified libros digitales.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id): View
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
    public function update(string $id, Request $request): RedirectResponse
    {

        $data = $this->getData($request);
        $librosDigitales = LibroDigital::findOrFail($id);

        if (!$data['romanos']) {
            $data['romanos'] = $this->handler->convertirNumberToRoman($data['number']);
        }


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
    public function destroy(string $id): ?RedirectResponse
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

    public function cargarLibro(Libro $libro)
    {
        $user = Auth::user();
        $libroDigital = $this->libroDigitalService->cargaLibroDigitaByLibro($libro, $user);


        return view('libros_digitales.verLibroDigital', compact('libroDigital', 'libro'));
    }

    public function cargarLibroByMesaAlumno(Libro $libro)
    {
        $user = Auth::user();
        $libroDigital = $this->libroDigitalService->cargaLibroDigitaByLibroByMesaAlumno($libro, $user);
        if(!$libroDigital){
            return redirect()->back()
                ->with('alert_danger', 'Libro Digital no encontrado.');
        }
        $mesaFolio = MesaFolio::where([
            'libro_digital_id' => $libroDigital->id,
            'folio' => $libro->folio
        ])->first();

        return view('libros_digitales.verLibroDigital', compact('libroDigital', 'libro', 'mesaFolio'));
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
            'number' => 'required|numeric|min:0|max:4294967295',
            'romanos' => 'nullable|string|min:1|max:10',
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
