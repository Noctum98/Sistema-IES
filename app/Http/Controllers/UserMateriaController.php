<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Carrera;
use App\Models\Materia;

use Illuminate\Http\Request;

class UserMateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.roles:admin-coordinador');
    }

    public function store(Request $request,$user_id)
    {
        $user = User::find($user_id);
        $carrera = Carrera::find($request['carrera']);
        $materia = Materia::find($request['materia']);

        if($user->hasSede($carrera->sede_id))
        {
            if(!$user->hasCarrera($carrera->id)){
                $user->carreras()->attach($carrera);
            }

            if($user->hasMateria($materia->id)){
                return redirect()->route('usuarios.admin')->with(['error_materia'=>'El usuario ya tiene asignado esta materia.']);
            }else{
                $user->materias()->attach($materia);
            }
        }else{
            return redirect()->route('usuarios.admin')->with(['error_sede'=>'El usuario no pertenece a esa sede']);
        }

        return redirect()->route('usuarios.admin')->with(['carrera_success'=>'Se han añadido la materia y carrera al usuario']);
    }

    public function delete($id,$materia_id)
    {
        $user = User::find($id);
        $user->materias()->detach(Materia::where('id',$materia_id)->first());

        return redirect()->route('usuarios.detalle',[
            'id' => $user->id
        ]);
    }
}
