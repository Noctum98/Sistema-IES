<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Proceso;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComisionController extends Controller
{

    protected $userService;

    function __construct(
        UserService $userService
    )
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente-coordinador');
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index($carrera_id)
    {
        $carrera = Carrera::find($carrera_id);
        $comisiones = Comision::where('carrera_id',$carrera->id)->get();

        return view('comision.index', [
            'comisiones' => $comisiones,
            'carrera' => $carrera
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $comision = Comision::find($id);
        $profesores = $this->userService->listadoRol('profesor',false,$comision->carrera_id,true);
        $procesos = Proceso::where('carrera_id',$comision->carrera_id)->get();


        return view('comision.detail',[
            'comision' => $comision,
            'profesores' => $profesores,
            'procesos' => $procesos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
