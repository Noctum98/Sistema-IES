<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Estados;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesoModular;
use App\Services\AsistenciaModularService;
use App\Services\CicloLectivoService;
use App\Services\ProcesoModularService;
use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Util\Exception;

class ProcesoModularController extends Controller
{
    /**
     * @var CicloLectivoService
     */
    private $cicloLectivoService;

    /**
     * @param CicloLectivoService $cicloLectivoService
     */
    public function __construct(CicloLectivoService $cicloLectivoService)
    {
        $this->cicloLectivoService = $cicloLectivoService;
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
     * Muestra los procesos de los cargos de cada módulo ponderados.
     * @param Materia $materia
     * @param int|null $ciclo_lectivo
     * @param int|null $cargo_id
     * @return Application|Factory|View
     */
    public function listado(Materia $materia, int $ciclo_lectivo =  null, int $cargo_id = null)
    {
        if(!$ciclo_lectivo){
            $ciclo_lectivo = date('Y');
        }


        $cargo = Cargo::find($cargo_id);
        $puedeProcesar = false;
        if($cargo and Auth::user()->hasCargo($cargo_id) and $cargo->responsableTFI($materia->id)){
            $puedeProcesar = true;
        };
        if(Auth::user()->hasAnyRole('coordinador') or Auth::user()->hasAnyRole('admin')){
            $puedeProcesar = true;
        }

        $acciones = [];
        $serviceModular = new ProcesoModularService();


        if (count($serviceModular->obtenerProcesosModularesNoVinculados($materia->id, $ciclo_lectivo)) > 0) {
            $acciones[] = "Creando procesos modulares para {$materia->nombre}";
            $serviceModular->crearProcesoModular($materia->id, $ciclo_lectivo);
        }




        $serviceModular->cargarPonderacionEnProcesoModular($materia, $ciclo_lectivo);


        $acciones[] = "Procesando % modulares para {$materia->nombre}";
//        if ($serviceModular->obtenerTimeUltimaCalificacion($materia->id)) {
//            if ($serviceModular->obtenerTimeUltimaCalificacion(
//                    $materia->id
//                )->updated_at >= $serviceModular->obtenerTimeUltimoProcesoModular($materia->id)->updated_at) {
//                $serviceModular->cargarPonderacionEnProcesoModular($materia);
//                $acciones[] = "Procesando % modulares para {$materia->nombre}";
//            }
//        }

        $asistenciaModular = new AsistenciaModularService();

        $asistencias = $asistenciaModular->cargarPonderacionEnAsistenciaModular($materia, $ciclo_lectivo);

        if ($asistencias > 0) {
            $acciones[] = "Procesando % asistencia para {$materia->nombre}";
        }

        $procesos = $serviceModular->obtenerProcesosModularesByMateria($materia->id, $ciclo_lectivo);

        $estados =  Estados::all();

        return view('procesoModular.listado', [
                'materia' => $materia,
                'cargo_id' => $cargo_id,
                'acciones' => $acciones,
                'procesos' => $procesos,
                'puede_procesar' => $puedeProcesar,
                'estados' => $estados,
                'ciclo_lectivo' => $ciclo_lectivo,
                'changeCicloLectivo' => $this->cicloLectivoService->getCicloInicialYActual(),
            ]
        );
    }

    public function procesaPonderacionModular(Materia $materia)
    {
        $acciones = [];
        $serviceModular = new ProcesoModularService();
        if (count($serviceModular->obtenerProcesosModularesNoVinculados($materia->id)) > 0) {
            $acciones[] = "Creando procesos modulares para {$materia->nombre}";
            $serviceModular->crearProcesoModular($materia->id);
        }

        $serviceModular->cargarPonderacionEnProcesoModular($materia);

    }

    public function procesaEstadosModular(Materia $materia, $ciclo_lectivo, int $cargo_id = null): RedirectResponse
    {
        $service = new ProcesoModularService();
        $service->grabaEstadoCursoEnModulo($materia->id, $ciclo_lectivo);

        return redirect()->route('proceso_modular.list', ['materia' => $materia,'ciclo_lectivo' =>$ciclo_lectivo, 'cargo_id' => $cargo_id]);

    }

    public function procesaNotaModular(Materia $materia,int $proceso_id, $cargo_id = null): RedirectResponse
    {
        $service = new ProcesoModularService();
        $proceso = Proceso::find($proceso_id);
        if(!$proceso){
            throw new Exception('No se encontró el proceso');
        }
        $nota_proceso = $service->revisaNotasProceso($materia, $proceso);

        $service->setNotaProceso($proceso_id, $nota_proceso);

        return redirect()->route('proceso_modular.list', ['materia' => $materia,'ciclo_lectivo' =>$proceso->ciclo_lectivo, 'cargo_id' => $cargo_id]);

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
