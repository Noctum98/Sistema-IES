<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Equivalencias;
use App\Models\Materia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
     * @throws ValidationException
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
            return redirect()->route('alumno.equivalencias')->withErrors($mensaje);
        }
        $materia = Materia::find($request['materia_id']);
        if (!$materia) {
            $mensaje = ['error_materia' => 'No se encontró la materia'];
            return redirect()->route('alumno.equivalencias', $alumno->dni)->withErrors($mensaje);
        }

        $equivalencia = Equivalencias::where([
            'materia_id' => $materia->id,
            'alumno_id' => $alumno->id
        ])
            ->first();

        if ($equivalencia) {
            $mensaje =  "El alumno ya tiene equivalencias en la materia: : {$materia->nombre}";
            return redirect()->route('alumno.equivalencias', $alumno->dni)->withErrors($mensaje);
        }
        $request['user_id'] = Auth::user()->id;
        $equivalencia = Equivalencias::create($request->all());

        if (!$equivalencia) {
            $mensaje = 'Hubo un error inesperado al crear la equivalencia. Por favor compruebe los datos ingresados';
            return redirect()->route('alumno.equivalencias', $alumno->dni)->withErrors($mensaje);
        }
        session()->flash(
            'success',
            "Se han añadido la equivalencia al alumno correctamente: {$materia->nombre}"
        );

        return redirect()->route('alumno.equivalencias', $alumno->dni)->withSuccess("Se han añadido la equivalencia al alumno correctamente: {$materia->nombre}");
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

    }
}
