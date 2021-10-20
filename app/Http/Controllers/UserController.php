<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\Sede;

class UserController extends Controller
{
    // Controlador de administación de usuarios

    public function vista_admin(){
        $users = User::all();
        $sedes = Sede::all();

        return view('user.admin',[
            'users' => $users,
            'sedes' => $sedes
        ]);
    }

    public function vista_editar(){
        $user = Auth::user();

        return view('user.edit',[
            'user'=>$user
        ]);
    }

    public function editar(Request $request){
        $user = Auth::user();

        $validate = $this->validate($request,[
            'username'=>['required','unique'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono'  => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->username = $request->input('username');
        $user->nombre = $request->input('nombre');
        $user->apellido = $request->input('apellido');
        $user->telefono = $request->input('telefono');
        $user->email = $request->input('email');
        $user->update();

        return redirect()->route('usuarios.editar',[
            'user'  =>  $user
        ])->with([
            'datos_editados'=>'Los datos personales han sido actualizados'
        ]);;
    }
    public function cambiar_contra(Request $request){
        $user = Auth::user();

        $validate = $this->validate($request,[
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $new_password = Hash::make($request->input('password'));
        $user->password = $new_password;
        $user->update();

        return redirect()->route('usuarios.editar',[
            'user'  =>  $user
        ])->with([
            'contraseña_nueva'  =>  'La contraseña ha sido actualizada'
        ]);
    }
    public function cambiar_rol(int $id ,string $rol){
        $user = User::find($id);

        if($rol != 'rol_admin' && $rol != 'rol_user'){
            return redirect()->route('usuarios.admin')->with([
                'error_rol' => 'Error al cambiar el rol'
            ]);
        }else{
            $user->rol = $rol;
            $user->update();
        }

        return redirect()->route('usuarios.admin')->with([
            'message' => 'Rol cambiado!'
        ]);
    
    }
    public function cambiar_sede(Request $request,int $id){
        $user = User::find($id);

        if(Auth::user()->rol == 'rol_admin' ){
            $user->sede_id = $request->input('sede');
            $user->update();

            return redirect()->route('usuarios.admin');
        }else{
            return redirect()->route('home');
        }
    }
}
