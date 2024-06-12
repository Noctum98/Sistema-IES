<?php

namespace App\Http\Controllers\Trianual;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trianual\StoreDetalleTrianualRequest;
use App\Http\Requests\Trianual\UpdateDetalleTrianualRequest;
use App\Models\Carrera;
use App\Models\Estados;
use App\Models\Materia;
use App\Models\Trianual\DetalleTrianual;
use App\Models\Trianual\Trianual;
use App\Services\EquivalenciasService;
use App\Services\ProcesoService;
use App\Services\Trianual\DetalleTrianualService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetalleTrianualController extends Controller
{
    /**
     * @var DetalleTrianualService
     */
    private $detalleTrianualService;
    /**
     * @var ProcesoService
     */
    private $procesoService;
    /**
     * @var EquivalenciasService
     */
    private $equivalenciasService;

    /**
     * @param DetalleTrianualService $detalleTrianualService
     * @param ProcesoService $procesoService
     * @param EquivalenciasService $equivalenciasService
     */
    public function __construct(DetalleTrianualService $detalleTrianualService, ProcesoService $procesoService, EquivalenciasService $equivalenciasService)
    {
        $this->detalleTrianualService = $detalleTrianualService;
        $this->procesoService = $procesoService;
        $this->equivalenciasService = $equivalenciasService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request, Trianual $trianual)
    {

        $detalles = $this->detalleTrianualService->detallesPorTrianual($trianual->id);
        return view('trianual.detalle.detail', [
            'detalles' => $detalles,
        ]);
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
     * @param \App\Http\Requests\Trianual\StoreDetalleTrianualRequest $request
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function store(StoreDetalleTrianualRequest $request)
    {
//        Necesito
//        'trianual_id',ok
//        'materia_id',ok
//        'condicion_id',ok
//        'equivalencia_id',ok
//        'proceso_id', ok
//        'operador_id',ok
//        'recursado',ok

//        Viene
//        "materia_id" => "490"
//  "estado_id" => "1"
//  "recursado" => "0"
//  "trianual" => "7"

        $data = $request->all();

        $trianual = Trianual::find($data['trianual_id']);
        $data['proceso_id'] = $this->procesoService->procesoPorAlumnoMateria($trianual->alumno_id, $data['materia_id'])->id ?? null;
        $data['equivalencia_id'] = $this->equivalenciasService->equivalenciaPorAlumnoMateria($trianual->alumno_id, $data['materia_id'])->id ?? null;
        $data['operador_id'] = Auth::user()->id;

        $detalleTrianual = DetalleTrianual::where([
            'trianual_id' => $trianual->id,
            'materia_id' => $data['materia_id']
        ])->first();
        $message = 'La materia ya está agregada';
        if (!$detalleTrianual) {
            $detalleTrianual = DetalleTrianual::create($data);
            $message = 'Detalle agregado correctamente';
        }

//        return view('trianual.detalle.detail', [
//            'trianual' => $trianual,
//            'alumno' => $trianual->getAlumno(),
//
//        ]);

        $estados = Estados::all();
        $detalles = $this->detalleTrianualService->detallesPorTrianual($trianual->id);

        session(['alert_success'=>$message]);



        return view('trianual.trianual.show', [
            'trianual' => $trianual,
            'estados' => $estados,
            'detalles' => $detalles
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DetalleTrianual $detalleTrianual
     * @return \Illuminate\Http\Response
     */
    public function show(DetalleTrianual $detalleTrianual)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DetalleTrianual $detalleTrianual
     * @return \Illuminate\Http\Response
     */
    public function edit(DetalleTrianual $detalleTrianual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Trianual\UpdateDetalleTrianualRequest $request
     * @param \App\Models\DetalleTrianual $detalleTrianual
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetalleTrianualRequest $request, DetalleTrianual $detalleTrianual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DetalleTrianual $detalleTrianual
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetalleTrianual $detalleTrianual)
    {
        //
    }

    public function generarDetalle(Trianual $trianual)
    {

        /** @var Carrera $carrera */
        $carrera = $trianual->getCarrera();

        $masterMaterias = $carrera->resoluciones()->first()->masterMaterias()->get();



        $condicion = Estados::where('identificador', 1)->first();

        $data= [];
        $data['condicion_id'] = $condicion->id;

        foreach ($masterMaterias as $mm) {

            $materia = Materia::where([
                'master_materia_id' => $mm->id,
                'carrera_id' => $carrera->id
            ])->first();
            $detalleTrianual = true;
            if($materia) {
                $detalleTrianual = DetalleTrianual::where([
                    'trianual_id' => $trianual->id,
                    'materia_id' => $materia->id
                ])->first();
            }

            if(!$detalleTrianual) {

                $data['trianual_id'] = $trianual->id;

                $data['materia_id'] = $materia->id;
                $data['proceso_id'] = $proceso = $this->procesoService->procesoPorAlumnoMateria($trianual->alumno_id, $materia->id)->id ?? null;
                $data['equivalencia_id'] = $this->equivalenciasService->equivalenciaPorAlumnoMateria($trianual->alumno_id, $materia->id)->id ?? null;

                if (is_object($proceso) && $proceso->estado_id) {
                    $data['condicion_id'] = $proceso->estado_id;
                }
                $data['operador_id'] = Auth::user()->id;

                $detalleTrianual = DetalleTrianual::create($data);

            }

        }




        $message = 'Detalles generados correctamente';
        session(['alert_success'=>$message]);

        $estados = Estados::all();
        $detalles = $this->detalleTrianualService->detallesPorTrianual($trianual->id);
        return view('trianual.trianual.show', [
            'trianual' => $trianual,
            'estados' => $estados,
            'detalles' => $detalles
        ]);



    }
}
