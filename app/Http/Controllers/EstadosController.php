<?php

namespace App\Http\Controllers;

use App\Models\Estados;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @author gerMdz gerardo.montivero@gmail.com
 */
class EstadosController extends Controller
{
    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente');
    }

    /**
     * Display a listing of the Estados.
     *
     */
    public function index()
    {
        $estados = Estados::all();

        return view('estados.admin', [
            'estados' => $estados,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Estados $estados
     * @return Response
     */
    public function create(Estados $estados)
    {
        // Usa modal
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request):RedirectResponse
    {
        $user = Auth::user();
        $validate = $this->validate($request, [
            'nombre' => ['required', 'string'],
            'identificador' => ['required', 'numeric'],
        ]);
        $estado = Estados::create($request->all());
        $estado->update(['user_action_id' => $user->id]);
        session()->flash(
            'success',
            "El nuevo estado {$estado->nombre} con identificador {$estado->identificador} fue creado"
        );

        return redirect()
            ->route('estados.index')
            ->withSuccess(
                "El nuevo estado {$estado->nombre} con identificador {$estado->identificador} fue creado"
            );

    }

    /**
     * Display the specified resource.
     *
     * @param Estados $estados
     * @return Response
     */
    public function show(Estados $estados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Estados $estado
     * @return Application|Factory|View
     */
    public function edit(Estados $estado)
    {
        return view('estados.modals.editar_estados')->with([
            'estado' => $estado,
        ]);
    }

    /**
     * Update Estados resource in storage.
     *
     * @param Request $request
     * @param Estados $estado
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Estados $estado): RedirectResponse
    {
        $user = Auth::user();
        $validate = $this->validate($request, [
            'nombre' => ['required', 'string'],
        ]);

        $estado->update([
            'nombre'=>$request->nombre,
            'user_action_id' => $user->id
        ]);



        return redirect()->route('estados.index')->with([
            'message' => 'Datos editados correctamente!',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Estados $estado
     * @return RedirectResponse
     */
    public function destroy(Estados $estado): RedirectResponse
    {
        $user = Auth::user();
        $estado->update(['user_action_id' => $user->id]);
        $estado->delete();

        return redirect()->route('estados.index')
            ->withSuccess(
                "El Estado {$estado->nombre} con identificador {$estado->identificador} fue borrado correctamente"
            );
    }
}
