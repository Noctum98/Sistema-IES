<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Sede;
use App\Models\Personal;

class PersonalController extends Controller
{
    function __construct()
    {
        $this->middleware('app.admin');
    }
    // Vistas

    public function vista_admin(){
        $personal = Personal::all();
        return view('personal.admin',[
            'personal' => $personal
        ]);
    }
    public function vista_crear(){
        $sedes = Sede::all();

        return view('personal.create',[
            'sedes' => $sedes
        ]);
    }
    public function vista_editar(int $id){
        $personal = Personal::find($id);
        $sedes = Sede::all();

        return view('personal.edit',[
            'personal'  => $personal,
            'sedes'     => $sedes
        ]); 
    }
    public function vista_detalle(int $id){
        $personal = Personal::find($id);

        return view('personal.detail',[
            'personal' => $personal
        ]); 
    }

    // Funcionalidades

    public function crear_personal(Request $request){
       $validate = $this->validate($request,[
            'sede_id'   => ['required','numeric'],
            'nombres'   =>['required'],
            'apellidos' => ['required'],
            'sexo'      => ['required','alpha'],
            'dni'       => ['required','numeric','unique:personal'],
            'cuil'      => ['required','numeric','unique:personal'],
            'cargo'     => ['required','alpha'],
            'titulo'    => ['required'],
            'telefono'  => ['required','numeric'],
            'fecha'     => ['required','date'],
            'estado'    => ['required','alpha']
       ]);

       $personal = new Personal();
       $personal->sede_id = $request->input('sede_id');
       $personal->nombres = $request->input('nombres');
       $personal->apellidos = $request->input('apellidos');
       $personal->sexo = $request->input('sexo');
       $personal->dni = $request->input('dni');
       $personal->cuil = $request->input('cuil');
       $personal->cargo = $request->input('cargo');
       $personal->titulo = $request->input('titulo');
       $personal->telefono = $request->input('telefono');
       $personal->fecha = $request->input('fecha');
       $personal->estado = $request->input('estado');

       $personal->save();

       return redirect()->route('personal.crear')->with([
            'message' => 'El personal ha sido creado con éxito'
       ]);
    }

    public function editar_personal(int $id,Request $request){
        $validate = $this->validate($request,[
            'sede_id'   => ['required','numeric'],
            'nombres'   =>['required'],
            'apellidos' => ['required'],
            'sexo'      => ['required','alpha'],
            'dni'       => ['required','numeric',Rule::unique('personal')->ignore($id)],
            'cuil'      => ['required','numeric',Rule::unique('personal')->ignore($id)],
            'cargo'     => ['required','alpha'],
            'titulo'    => ['required'],
            'telefono'  => ['required','numeric'],
            'fecha'     => ['required','date'],
            'estado'    => ['required','alpha']
        ]);

        $personal = Personal::find($id);
        $personal->sede_id = $request->input('sede_id');
        $personal->nombres = $request->input('nombres');
        $personal->apellidos = $request->input('apellidos');
        $personal->sexo = $request->input('sexo');
        $personal->dni = $request->input('dni');
        $personal->cuil = $request->input('cuil');
        $personal->cargo = $request->input('cargo');
        $personal->titulo = $request->input('titulo');
        $personal->telefono = $request->input('telefono');
        $personal->fecha = $request->input('fecha');
        $personal->estado = $request->input('estado');
        $personal->update();

        return redirect()->route('personal.editar',['id'=>$id])->with([
            'message'   =>  'La ficha ha sido actualizada correctamente!'
        ]);
    }
    public function descargar_ficha(int $id){
        $personal = Personal::find($id);
        $data = [
            'personal' => $personal
        ];

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pdfs.personal_ficha',$data);

        return $pdf->download('Ficha '.$personal->nombres.' '.$personal->apellidos.'.pdf');
    }
}
