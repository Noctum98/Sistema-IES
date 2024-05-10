<?php

namespace App\Http\Controllers\Parameters;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCicloLectivoEspecialRequest;
use App\Http\Requests\UpdateCicloLectivoEspecialRequest;
use App\Models\ActaVolante;
use App\Models\Materia;
use App\Models\Parameters\CicloLectivo;
use App\Models\Parameters\CicloLectivoEspecial;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CicloLectivoEspecialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Materia $materia)
    {

        $ciclosLectivos = CicloLectivo::all()->sortBy('year',1, true ,);
        return view('materia.modal.form_agregar_ciclo_lectivo_especial')->with([
            'materia' => $materia,
            'ciclos_lectivos' => $ciclosLectivos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCicloLectivoEspecialRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCicloLectivoEspecialRequest $request)
    {
        $validate = $this->validate($request, [
            'ciclo_lectivo_id' => ['required'],
            'regimen' => ['required'],
            'sede_id' => ['required'],
            'materia_id' => ['required'],
            'cierre_ciclo' => ['required'],
        ]);
         CicloLectivoEspecial::create($request->all());
         $materia = $request->get('materia_id');
        return redirect()->route('materia.editar', ['id' => $materia])->with([
            'message' => 'Materia editada correctamente!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CicloLectivoEspecial  $cicloLectivoEspecial
     * @return \Illuminate\Http\Response
     */
    public function show(CicloLectivoEspecial $cicloLectivoEspecial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CicloLectivoEspecial $ciclo_lectivo_especial
     * @return Application|Factory|\Illuminate\View\View|View
     */
    public function edit(CicloLectivoEspecial $ciclo_lectivo_especial)
    {
        $ciclosLectivos = CicloLectivo::all()->sortBy('year',1, true ,);

        return view('materia.modal.form_editar_ciclo_lectivo_especial')->with([
            'ciclos_lectivos' => $ciclosLectivos,
            'materia' => $ciclo_lectivo_especial->materia()->first(),
            'c_lectivo' => $ciclo_lectivo_especial,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCicloLectivoEspecialRequest $request
     * @param CicloLectivoEspecial $cicloLectivoEspecial
     * @return RedirectResponse
     */
    public function update(UpdateCicloLectivoEspecialRequest $request, CicloLectivoEspecial $cicloLectivoEspecial): RedirectResponse
    {
        $validate = $this->validate($request, [
            'ciclo_lectivo_id' => ['required'],
            'regimen' => ['required'],
            'sede_id' => ['required'],
            'materia_id' => ['required'],
            'cierre_ciclo' => ['required'],
        ]);
        $cicloLectivoEspecial->update($request->all());
        $materia = $cicloLectivoEspecial->materia()->first()->id;
        return redirect()->route('materia.editar', ['id' => $materia])->with([
            'message' => 'Ciclo lectivo editado correctamente!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CicloLectivoEspecial  $cicloLectivoEspecial
     * @return \Illuminate\Http\Response
     */
    public function destroy(CicloLectivoEspecial $cicloLectivoEspecial)
    {
        //
    }
}
