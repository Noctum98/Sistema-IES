<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActaVolante;
use App\Models\Alumno;
use App\Models\FolioNota;
use App\Models\Libro;
use App\Models\MesaFolio;
use App\Models\User;
use App\Repository\FolioRepository;
use App\Repository\Sede\SedeRepository;
use App\Services\Trianual\FolioNotasService;
use App\Services\Trianual\MesaFolioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class FolioNotasController extends Controller
{

    private FolioNotasService $folioNotasService;


    /**
     * @param FolioNotasService $folioNotasService
     */
    public function __construct(FolioNotasService $folioNotasService)
    {
        $this->folioNotasService = $folioNotasService;
    }

    /**
     * Display a listing of the folio notas.
     *
     * @return View
     */
    public function index()
    {
        $sedes = $this->getSedes();

        $folioNotas = FolioNota::with('actaVolante', 'alumno', 'mesaFolio', 'user')
            ->paginate(25);

        return view('folio_notas.index', compact('folioNotas'));
    }

    /**
     * Show the form for creating a new folio nota.
     *
     * @return View
     */
    public function create()
    {


        $sedesId = $this->getSedes();

        $sedeRepository = new SedeRepository;

        $librosDigitales = $sedeRepository->getLibrosDigitalesSedes($sedesId);

        if (!count($librosDigitales)) {
            return $this->returnIndex('No existen libros digitales en sus sedes', 'error_message');
        }

        $folioRepository = new FolioRepository;

        $MesaFolios = $folioRepository->getFoliosByLibrosDigitales($librosDigitales->pluck('id')->toArray());


//        dd($mesaFolios);

//        $MesaFolios = MesaFolio::pluck('numero', 'id')->all();


        $ActasVolantes = ActaVolante::pluck('id', 'id')->all();
        $Alumnos = Alumno::pluck('apellidos', 'id')->all();


        return view(
            'folio_notas.create', compact('ActasVolantes', 'Alumnos', 'MesaFolios', 'librosDigitales'));
    }


    /**
     * Show the form for creating a new folio nota.
     *
     * @return View
     */
    public function createByFolio(MesaFolio $id)
    {

        $sedesId = $this->getSedes();

        $sedeRepository = new SedeRepository;

        $librosDigitales = $sedeRepository->getLibrosDigitalesSedes($sedesId);

        if (!count($librosDigitales)) {
            return $this->returnIndex('No existen libros digitales en sus sedes', 'error_message');
        }

        $folioRepository = new FolioRepository;

        $mesaFolios = $folioRepository->getFoliosByLibrosDigitales($librosDigitales->pluck('id')->toArray());


//        $MesaFolios = MesaFolio::pluck('numero', 'id')->all();


        $ActasVolantes = ActaVolante::pluck('id', 'id')->all();
        $Alumnos = Alumno::pluck('apellidos', 'id')->all();


        return view(
            'folio_notas.create', compact('ActasVolantes', 'Alumnos', 'MesaFolios', 'librosDigitales'));
    }

    /**
     * Store a new folio nota in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        dd($request->all());

        $data = $this->getData($request);

        FolioNota::create($data);

        return redirect()->route('folio_notas.folio_nota.index')
            ->with('success_message', 'Se ha agregado una nueva nota.');
    }

    /**
     * Display the specified folio nota.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $folioNota = FolioNota::with('actaVolante', 'alumno', 'mesaFolio', 'user')->findOrFail($id);

        return view('folio_notas.show', compact('folioNota'));
    }

    /**
     * Show the form for editing the specified folio nota.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $folioNota = FolioNota::findOrFail($id);
        $ActasVolantes = ActaVolante::pluck('id', 'id')->all();
        $Alumnos = Alumno::pluck('apellidos', 'id')->all();
        $MesaFolios = MesaFolio::pluck('numero', 'id')->all();

        return view('folio_notas.edit', compact('folioNota', 'ActasVolantes', 'Alumnos', 'MesaFolios'));
    }

    /**
     * Update the specified folio nota in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $folioNota = FolioNota::findOrFail($id);
        $folioNota->update($data);

        return redirect()->route('folio_notas.folio_nota.index')
            ->with('success_message', 'La nota ha sido actualizada correctamente.');
    }

    /**
     * Remove the specified folio nota from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $folioNota = FolioNota::findOrFail($id);
            $folioNota->delete();

            return redirect()->route('folio_notas.folio_nota.index')
                ->with('success_message', 'La nota ha sido eliminada correctamente.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ha ocurrido un error inesperado al intentar procesar su solicitud.']);
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
            'acta_volante_id' => 'nullable',
            'alumno_id' => 'nullable',
            'definitiva' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'escrito' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'mesa_folio_id' => 'required',
            'oral' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'orden' => 'required|numeric|min:-2147483648|max:2147483647',
            'permiso' => 'nullable|numeric|min:-2147483648|max:2147483647',
        ];

        return $request->validate($rules);
    }

    public function returnIndex(string $message = null, string $type = 'success_message')
    {

        return redirect()->route('folio_notas.folio_nota.index')->with(
            $type,
            $message
        );

    }

    public function cargaActasVolantesByLibro(MesaFolio $mesaFolio, Libro $libro)
    {
         $this->folioNotasService->cargaNotas($libro, $mesaFolio, auth()->user());

         $folio = MesaFolio::find($mesaFolio->id);

        return view('folio_notas.verFolioNotas', compact('folio'));

    }

}
