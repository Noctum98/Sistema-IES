<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\RolUser;

class RolController extends Controller
{
    public function index()
    {
        $roles_primarios = Rol::where('tipo',0)->get();
        $roles_secundarios = Rol::where('tipo',1)->get();

        return view('rol.admin',[
            'roles_primarios' => $roles_primarios,
            'roles_secundarios' => $roles_secundarios
        ]);
    }

    public function store(Request $request){
        $validate = $this->validate($request,[
            'nombre' => ['required','alpha'],
            'descripcion' => ['required'],
            'tipo' => ['required','integer']
        ]);

        $rol = Rol::create($request->all());

        return redirect()->route('roles.index')
        ->with('rol_creado','El rol '.$rol->descripcion.' se ha creado correctamente.');
    }

    public function destroy($id){
        $rol_users = RolUser::where('rol_id',$id)->delete();

        $rol = Rol::find($id)->delete();

        return redirect()->route('roles.index')
        ->with('rol_eliminado','El rol se ha eliminado correctamente.');
    }
}
