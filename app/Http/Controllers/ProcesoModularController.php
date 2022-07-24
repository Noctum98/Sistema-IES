<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\ProcesoModular;
use App\Services\ProcesoModularService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProcesoModularController extends Controller
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
     * Muestra los procesos de los cargos de cada módulo ponderados.
     * @param Materia $materia
     * @param int $cargo_id
     * @return Application|Factory|View
     */
    public function list(Materia $materia, int $cargo_id)
    {
        $acciones = [];
        $serviceModular = new ProcesoModularService();
        if(count($serviceModular->obtenerProcesosModularesNoVinculados($materia->id)) > 0){
            $acciones[] = "Creando procesos modulares para {$materia->nombre}";
            $serviceModular->crearProcesoModular($materia->id);
        }
        $procesos = $serviceModular->obtenerProcesosModularesByMateria($materia->id);

        return view('procesoModular.listado', [
                'materia' => $materia,
                'cargo_id' => $cargo_id,
                'acciones' => $acciones,
                'procesos' => $procesos
            ]
        );


    }

    public function procesaPonderacionModular(Materia $materia)
    {
        $acciones = [];
        $serviceModular = new ProcesoModularService();
        if(count($serviceModular->obtenerProcesosModularesNoVinculados($materia->id)) > 0){
            $acciones[] = "Creando procesos modulares para {$materia->nombre}";
            $serviceModular->crearProcesoModular($materia->id);
        }

        $serviceModular->cargarPonderacionEnProcesoModular($materia);




    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProcesoModular $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function show(ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProcesoModular $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProcesoModular $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcesoModular $procesoModular)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProcesoModular $procesoModular
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcesoModular $procesoModular)
    {
        //
    }
}
