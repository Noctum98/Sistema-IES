<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LibroDigital;
use App\Models\MasterMateria;
use App\Models\Mesa;
use App\Models\MesaFolio;
use App\Models\User;
use App\Repository\Sede\SedeRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class MesaFoliosController extends Controller
{

    /**
     * Display a listing of the mesa folios.
     *
     * @return View
     */
    public function index()
    {
        $mesaFolios = MesaFolio::with('user', 'libroDigital', 'masterMateria', 'mesa')->paginate(25);

        return view('mesa_folios.index', compact('mesaFolios'));
    }

    /**
     * Show the form for creating a new mesa folio.
     *
     * @return View
     */
    public function create()
    {
        $Users = User::pluck('activo', 'id')->all();
        $LibrosDigitales = LibroDigital::pluck('romanos', 'id')->all();
        $MasterMaterias = MasterMateria::pluck('name', 'id')->all();
        $Mesas = Mesa::pluck('cierre', 'id')->all();

        return view('mesa_folios.create', compact('Users', 'LibrosDigitales', 'MasterMaterias', 'Mesas', 'Users'));
    }


    /**
     * Show the form for creating a new mesa folio.
     *
     * @param LibroDigital $libroDigital
     * @return View
     */
    public function createByLibro(LibroDigital $libroDigital): View
    {

        $LibrosDigitales = [$libroDigital];
        $MasterMaterias = MasterMateria::pluck('name', 'id')->all();
        $Mesas = Mesa::pluck('cierre', 'id')->all();

        $sede = $this->getSedes();

        $sedeRepository = new SedeRepository();

//        $Users = $sedeRepository->getUsersSehpdes($sede);
        $Users = User::all();
//        dd($Users);


        return view('mesa_folios.create', compact('Users', 'LibrosDigitales', 'MasterMaterias', 'Mesas', 'Users'));
    }

    /**
     * Show the form for creating a new mesa folio.
     *
     * @param LibroDigital $libroDigital
     * @return View
     */
    public function createByLibroFromLibro(LibroDigital $libroDigital): View
    {

        $MasterMaterias = MasterMateria::
        where('resoluciones_id', $libroDigital->resoluciones_id)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');

        $sedeRepository = new SedeRepository();

        $Users = $sedeRepository->getProfesoresSede([$libroDigital->sede_id]);

        return view('mesa_folios.create_from_libro', compact('Users', 'libroDigital', 'MasterMaterias', 'Users'));
    }

    /**
     * Store a new mesa folio in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {


        $data = $this->getData($request);

        $user = auth()->user();
        $data['user_id'] = $user->id;

        $mesaFolio = MesaFolio::where([
            'libro_digital_id' => $data['libro_digital_id'],
            'folio' => $data['folio']
        ]);

        if ($mesaFolio->exists()) {
            return redirect()->back()
                ->with('alert_danger', 'El número de folio para el Libro Digital ya existe.');
        }

        $mesaFolio =MesaFolio::create($data);

        return redirect()->route('libros_digitales.libro_digital.showFolios', [
            'libroDigital' => $mesaFolio->libro_digital_id,
            'page' => $mesaFolio->folio
            ])
            ->with('success_message', 'Folio ha sido guardado correctamente.');
    }

    /**
     * Display the specified mesa folio.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $mesaFolio = MesaFolio::with('user', 'libroDigital', 'masterMateria', 'mesa')->findOrFail($id);

        return view('mesa_folios.show', compact('mesaFolio'));
    }

    /**
     * Show the form for editing the specified mesa folio.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $mesaFolio = MesaFolio::findOrFail($id);
        $Users = User::pluck('activo', 'id')->all();
        $LibrosDigitales = LibroDigital::pluck('acta_inicio', 'id')->all();
        $MasterMaterias = MasterMateria::pluck('name', 'id')->all();
        $Mesas = Mesa::pluck('cierre', 'id')->all();

        return view('mesa_folios.edit', compact('mesaFolio', 'Users', 'LibrosDigitales', 'MasterMaterias', 'Mesas', 'Users'));
    }

    /**
     * Update the specified mesa folio in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $mesaFolio = MesaFolio::findOrFail($id);
        $mesaFolio->update($data);

        return redirect()->route('mesa_folios.mesa_folio.index')
            ->with('success_message', 'Folio ha sido guardado correctamente.');
    }

    /**
     * Remove the specified mesa folio from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $mesaFolio = MesaFolio::findOrFail($id);
            $mesaFolio->delete();

            return redirect()->route('mesa_folios.mesa_folio.index')
                ->with('success_message', 'Folio ha sido eliminado correctamente.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ha ocurrido un error inesperado. ' . $exception->getMessage() . ' (' . $exception->getCode() . ')']);
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
            'aprobados' => 'nullable|numeric|min:0|max:26',
            'ausentes' => 'nullable|numeric|min:0|max:26',
            'coordinador_id' => 'nullable',
            'desaprobados' => 'nullable|numeric|min:0|max:26',
            'fecha' => 'required|date_format:Y-m-d',
            'libro_digital_id' => 'required',
            'master_materia_id' => 'required',
            'mesa_id' => 'nullable',
            'folio' => 'required|numeric|min:1|max:250',
            'operador_id' => 'nullable',
            'presidente_id' => 'nullable',
            'turno' => 'nullable|string|min:0|max:191',
            'vocal_1_id' => 'nullable',
            'vocal_2_id' => 'nullable',
        ];

        return $request->validate($rules);
    }

}
