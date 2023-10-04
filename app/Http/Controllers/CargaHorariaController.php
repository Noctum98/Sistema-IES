<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCargaHorariaRequest;
use App\Http\Requests\UpdateCargaHorariaRequest;
use App\Models\CargaHoraria;
use App\Models\ComposicionHoraria;
use App\Models\Estados;
use App\Models\Materia;
use App\Models\Personal;
use App\Models\Proceso;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CargaHorariaController extends Controller
{


    function __construct()
    {
        $this->middleware('app.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        $personal = User::usersPersonal();

        return view('cargaHoraria.listado', [
            'personal' => $personal
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(int $persona)
    {

        $profesor = User::find($persona);

        $carreras = $profesor->carreras()->get();

        return view('cargaHoraria.components.form_agregar_cargaHoraria')->with([
            'carreras' => $carreras,
            'profesor' => $profesor
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCargaHorariaRequest $request
     * @param int $persona
     * @return Application|Factory|View
     */
    public function store(StoreCargaHorariaRequest $request, int $persona)
    {
        $request['profesor_id'] = $persona;
        $user = Auth::user();

        $request['usuario_id'] =  $user->id;

        $ch = CargaHoraria::create($request->all());

        $mensaje = ['calificacion_creada' => 'Carga horaria asignada correctamente'];

        ComposicionHoraria::create([
            'carga_principal_id' => $ch->id,
            'is_principal' => true,
            'compositable_id' => $ch->materia_id,
            'compositable_type' => Materia::class,
            'cantidad_horas' => $ch->cantidad_horas,
            'usuario_id' => $user->id
        ]);


        $cargaHoraria = CargaHoraria::where([
            'profesor_id' => $persona
        ])->get();
        $profesor = User::find($persona);

        return view('cargaHoraria.ver', [
            'cargaHoraria' => $cargaHoraria,
            'user' => $profesor,
            'mensaje' => $mensaje
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param User $persona
     * @return Application|Factory|View
     */
    public function show(User $persona)
    {
        $cargaHoraria = CargaHoraria::where([
            'profesor_id' => $persona->id
        ])->get();



        return view('cargaHoraria.ver', [
            'cargaHoraria' => $cargaHoraria,
            'user' => $persona
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CargaHoraria $cargaHoraria
     * @return Response
     */
    public function edit(CargaHoraria $cargaHoraria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCargaHorariaRequest $request
     * @param CargaHoraria $cargaHoraria
     * @return Response
     */
    public function update(UpdateCargaHorariaRequest $request, CargaHoraria $cargaHoraria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CargaHoraria $cargaHoraria
     * @return Response
     */
    public function destroy(CargaHoraria $cargaHoraria)
    {
        //
    }
}
