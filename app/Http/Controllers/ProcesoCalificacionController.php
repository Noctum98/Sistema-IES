<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\ProcesoCalificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcesoCalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-profesor-seccionAlumnos-coordinador');
    }

    public function store(Request $request)
    {

        $ausente = false;
        if($request['porcentaje'] && is_numeric($request['porcentaje'])){
            $rules = ['required','numeric','max:100'];
        }else{
            $rules = ['required','string','regex:/^[A?a?]/'];
            $ausente = true;
        }
        $validate = Validator::make($request->all(),[
            'porcentaje' => $rules
        ]);

        if(!$validate->fails())
        {
            $procesoCalificacion = ProcesoCalificacion::where([
                'proceso_id' => $request['proceso_id'],
                'calificacion_id' => $request['calificacion_id']
            ])->first();
    
            if($procesoCalificacion)
            {
                $procesoCalificacion->porcentaje = $request['porcentaje'];

                if(!$ausente)
                {
                    $procesoCalificacion->nota = $this->calcularNota((int) $request['porcentaje']);
                }else{
                    $procesoCalificacion->nota = 'A';
                }
                $procesoCalificacion->update();
            }else{
                $request['nota'] = $ausente ? $request['porcentaje'] : $this->calcularNota((int) $request['porcentaje']);
                $procesoCalificacion = ProcesoCalificacion::create($request->all());
            }

            $reponse = $procesoCalificacion;
        }else{
            $reponse = [
                'code' => 200,
                'errors' => $validate->errors()
            ];
        }
       

        return response()->json($reponse,200);
    }

    public function crearRecuperatorio(Request $request)
    {
        $ausente = false;
        if($request['porcentaje'] && is_numeric($request['porcentaje'])){
            $rules = ['required','numeric','max:100'];
        }else{
            $rules = ['required','string','regex:/^[A?a?]/'];
            $ausente = true;
        }
        $validate = Validator::make($request->all(),[
            'porcentaje' => $rules
        ]);

        if(!$validate->fails())
        {
            $procesoCalificacion = ProcesoCalificacion::where([
                'proceso_id' => $request['proceso_id'],
                'calificacion_id' => $request['calificacion_id']
            ])->first();

            $procesoCalificacion->porcentaje_recuperatorio = $request['porcentaje'];

            if (!$ausente) {
                $procesoCalificacion->nota_recuperatorio = $this->calcularNota((int) $request['porcentaje']);
            }else{
                $procesoCalificacion->nota_recuperatorio = 'A';
            }

            $procesoCalificacion->update();

            $response = $procesoCalificacion;
        }else{
            $response = [
                'code' => 200,
                'errors' => $validate->errors()
            ];
        }

        return response()->json($response,200);
    }

    private function calcularNota($porcentaje)
    {
        if($porcentaje == 0)
        {
            $nota = 0;
        }else if($porcentaje >= 1 && $porcentaje <= 19 )
        {
            $nota = 1;
        }else if($porcentaje >=20 && $porcentaje <=39)
        {
            $nota = 2;
        }else if($porcentaje >=40 && $porcentaje <=59)
        {
            $nota = 3;
        }else if($porcentaje >=60 && $porcentaje <=65)
        {
            $nota = 4;
        }else if($porcentaje >=66 && $porcentaje <=71)
        {
            $nota = 5;
        }else if($porcentaje >=72 && $porcentaje <=77)
        {
            $nota = 6;
        }else if($porcentaje >=78 && $porcentaje <=83)
        {
            $nota = 7;
        }else if($porcentaje >=84 && $porcentaje <=89)
        {
            $nota = 8;
        }else if($porcentaje >=90 && $porcentaje <=95)
        {
            $nota = 9;
        }else if($porcentaje >=96 && $porcentaje <=100)
        {
            $nota = 10;
        }

        return $nota;
    }
}
