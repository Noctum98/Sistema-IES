<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LibrosController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'mesa_id' => ['required'],
            'llamado' => ['required'],
        ]);

        if(!$validation->fails())
        {
            //dd($request['folios']);
            foreach($request['folios'] as $folio)
            {
                $numero_folio = explode('-',$folio);
                $request['folio'] = $numero_folio[0];
                $request['orden'] = $numero_folio[1];

                $libro = Libro::where([
                    'mesa_id' => $request['mesa_id'],
                    'llamado' => $request['llamado'],
                    'folio' => $request['folio']
                ])->first();

                
                if($libro)
                {
                   $libroExist = $libro->update($request->all());
                    
                }else{
                    $libro = Libro::create($request->all());
                }

                $this->setLibroActasVolantes($libro);

            }

            $data = [
                'status' => 'success',
                'data' => 'Libros creados!'
            ];
        }else{
            $data = [
                'status' => 'error',
                'data' => $validation->errors()
            ];
        }

        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function setLibroActasVolantes($libro)
    {
        $mesa = $libro->mesa;

        if($libro->llamado == 1)
        {
            $inscripciones = $mesa->mesa_inscriptos_primero($libro->orden);
        }elseif($libro->llamado == 2){
            $inscripciones = $mesa->mesa_inscriptos_segundo($libro->orden);
        }else{
            $inscripciones = $mesa->mesa_inscriptos();
        }
        foreach($inscripciones as $inscripcion)
        {
            $acta_volante = $inscripcion->acta_volante ?? null;
            if($acta_volante)
            {
                $acta_volante->libro_id = $libro->id;
                $acta_volante->update();
            }
        }
    }
}
