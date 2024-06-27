<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActaVolante;
use App\Models\Alumno;
use App\Models\FolioNota;
use App\Models\MesaFolio;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class FolioNotasController extends Controller
{

    /**
     * Display a listing of the folio notas.
     *
     * @return View
     */
    public function index()
    {
        $folioNotas = FolioNota::with('actaVolante', 'alumno', 'mesaFolio', 'user')->paginate(25);

        return view('folio_notas.index', compact('folioNotas'));
    }

    /**
     * Show the form for creating a new folio nota.
     *
     * @return View
     */
    public function create()
    {
        $ActasVolantes = ActaVolante::pluck('id', 'id')->all();
        $Alumnos = Alumno::pluck('apellidos', 'id')->all();
        $MesaFolios = MesaFolio::pluck('numero', 'id')->all();

        return view('folio_notas.create', compact('ActasVolantes', 'Alumnos', 'MesaFolios'));
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

}
