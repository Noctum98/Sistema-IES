<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCargoProcesoRequest;
use App\Http\Requests\UpdateCargoProcesoRequest;
use App\Models\Cargo;
use App\Models\CargoProceso;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesosCargos;
use App\Services\CalificacionService;
use App\Services\CargoProcesoService;
use App\Services\ProcesoModularService;
use App\Services\ProcesosCargosService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Util\Exception;

class CargoProcesoController extends Controller
{
    /**
     * @var CargoProcesoService
     */
    private $cargoProcesoService;
    /**
     * @var ProcesosCargosService
     */
    private $procesosCargosService;

    /**
     * @param CargoProcesoService $cargoProcesoService
     * @param ProcesosCargosService $procesosCargosService
     */
    public function __construct(CargoProcesoService $cargoProcesoService, ProcesosCargosService $procesosCargosService)
    {
        $this->cargoProcesoService = $cargoProcesoService;
        $this->procesosCargosService = $procesosCargosService;
    }

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCargoProcesoRequest $request
     * @param int $proceso_id
     * @param int $cargo_id
     * @return RedirectResponse
     */
    public function store(StoreCargoProcesoRequest $request, int $proceso_id, int $cargo_id): RedirectResponse
    {

        $user = Auth::user();

        /** @var Proceso $proceso */
        $proceso = Proceso::find($proceso_id);

        if (!$proceso) {
            throw new Exception('No se encontró el proceso');
        }

        /** @var Cargo $cargo */
        $cargo = Cargo::find($cargo_id);

        if (!$cargo) {
            throw new Exception('No se encontró el cargo');
        }

        $cargoProceso = CargoProceso::where([
            'proceso_id' => $proceso->id,
            'cargo_id' => $cargo->id
        ])->first();


        $procesosCargos = ProcesosCargos::where([
            'proceso_id' => $proceso->id,
            'cargo_id' => $cargo->id
        ])->first();

        if (!$procesosCargos) {
            $this->procesosCargosService->crear($proceso->id, $cargo->id, $user->id, false);
        }

        if (!$cargoProceso) {
            $cargoProceso = $this->cargoProcesoService->generaCargoProceso(
                $cargo->id, $proceso->id, $user->id, $proceso->ciclo_lectivo, false);
        }

        $materia = Materia::find($proceso->materia_id);

        $this->cargoProcesoService->actualizaCargoProceso($cargo->id, $proceso, $materia, $cargoProceso);

        return redirect()->route('proceso.listadoCargo',
            [$materia->id, $cargo->id,$proceso->ciclo_lectivo])
            ->with('mensaje_exitoso','Cargo proceso generado');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CargoProceso $cargoProceso
     * @return \Illuminate\Http\Response
     */
    public function show(CargoProceso $cargoProceso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CargoProceso $cargoProceso
     * @return \Illuminate\Http\Response
     */
    public function edit(CargoProceso $cargoProceso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCargoProcesoRequest $request
     * @param CargoProceso $cargoProceso
     * @return RedirectResponse
     */
    public function update(UpdateCargoProcesoRequest $request, CargoProceso $cargoProceso): RedirectResponse
    {
        /** @var Proceso $proceso */
        $proceso = Proceso::find($cargoProceso->proceso_id);
        $materia = Materia::find($proceso->materia_id);
        $this->cargoProcesoService->actualizaCargoProceso($cargoProceso->cargo_id, $proceso, $materia, $cargoProceso);

        return redirect()->route('proceso.listadoCargo',
            [$materia->id, $proceso->cargo_id,$proceso->ciclo_lectivo]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CargoProceso $cargoProceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(CargoProceso $cargoProceso)
    {
        //
    }
}
