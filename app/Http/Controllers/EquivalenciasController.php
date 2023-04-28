<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Equivalencias;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EquivalenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse | Response
     *
     */
    public function create($idAlumno)
    {
        $alumno = Alumno::find($idAlumno);
        if (!$alumno) {
            return redirect()->back();
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse | Response
     */
    public function store(Request $request)
    {


        $validate = $this->validate($request, [
            'alumno_id' => ['required'],
            'materia_id' => ['required'],
            'nota' => ['required'],
            'fecha' => ['required'],
            'resolution' => ['required'],
        ]);



        $alumno = Alumno::find($request['alumno_id']);

        if (!$alumno) {
            $mensaje = ['error_alumno' => 'No se encontró al alumno'];

            return redirect()->route('alumno.equivalencias')->with($mensaje);
        }
        $materia = Alumno::find($request['materia_id']);
        if (!$materia) {
            $mensaje = ['error_materia' => 'No se encontró la materia'];

            return redirect()->route('alumno.equivalencias')->with($mensaje);
        }

        $equivalencia = Equivalencias::where([
            'materia_id' => $materia->id,
            'alumno_id' => $alumno->id
        ])
            ->first();

        if ($equivalencia) {
            $mensaje = ['error_equivalencia' => 'El alumno ya tiene equivalencias en la materia'];
            return redirect()->route('alumno.equivalencias')->with($mensaje);
        }
        $request['user_id'] = Auth::user()->id;
        $equivalencia = Equivalencias::create($request->all());

        if (!$equivalencia) {
            $mensaje = ['error_equivalencia' => 'Hubo un error inesperado al crear la equivalencia. Por favor compruebe los datos ingresados'];
            return redirect()->route('alumno.equivalencias')->with($mensaje);
        }


        return redirect()->route('alumno.equivalencias', $alumno->dni)->with(['equivalencias_success' => 'Se han añadido la equivalencia al alumno correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Equivalencias $equivalencias
     * @return Response
     */
    public function show(Equivalencias $equivalencias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Equivalencias $equivalencias
     * @return Response
     */
    public function edit(Equivalencias $equivalencias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Equivalencias $equivalencias
     * @return Response
     */
    public function update(Request $request, Equivalencias $equivalencias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Equivalencias $equivalencias
     * @return Response
     */
    public function destroy(Equivalencias $equivalencias)
    {
        //
    }
}
