<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\RolUser;

class RolController extends Controller
{

    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin');
    }

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
            'nombre' => ['required'],
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

    public function cambiarEstado(Request $request,$rol_id)
    {
        $rol = Rol::find($rol_id);
        $message = '';

        if($rol->activo)
        {
            $rol->activo = false;
            $message = 'Rol desactivado correctamente';
        }else{
            $rol->activo = true;
            $message = 'Rol activado correctamente';
        }

        $rol->update();

        return redirect()->back()->with(['alert_success'=>$message]);
    }
}
