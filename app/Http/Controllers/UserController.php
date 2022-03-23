<?php

namespace App\Http\Controllers;

use App\Mail\MatriculacionUser;
use App\Models\Alumno;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolUser;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\Sede;
use App\Models\SedeUser;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.roles:admin-usuarios',['only'=>['vista_admin','set_roles','cambiar_sedes','crear_usuario_alumno']]);

    }
    // Controlador de administación de usuarios

    public function vista_admin()
    {
        $users = User::all();
        $sedes = Sede::all();
        $roles_primarios = Rol::where('tipo', 0)->get();
        $roles_secundarios = Rol::where('tipo', 1)->get();

        return view('user.admin', [
            'users' => $users,
            'sedes' => $sedes,
            'roles_primarios' => $roles_primarios,
            'roles_secundarios' => $roles_secundarios
        ]);
    }

    public function vista_editar()
    {
        $user = Auth::user();

        return view('user.edit', [
            'user' => $user
        ]);
    }

    public function editar(Request $request)
    {
        $user = Auth::user();

        $validate = $this->validate($request, [
            'username' => ['required', Rule::unique('users')->ignore($user->id)],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono'  => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($request->all());

        return redirect()->route('usuarios.editar', [
            'user'  =>  $user
        ])->with([
            'datos_editados' => 'Los datos personales han sido actualizados'
        ]);;
    }
    public function cambiar_contra(Request $request)
    {
        $user = Auth::user();

        $validate = $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $new_password = Hash::make($request->input('password'));
        $user->password = $new_password;
        $user->update();

        return redirect()->route('usuarios.editar', [
            'user'  =>  $user
        ])->with([
            'contraseña_nueva'  =>  'La contraseña ha sido actualizada'
        ]);
    }
    public function set_roles(Request $request, $id)
    {
        $user = User::find($id);
        $roles = $request->roles;

        // Verifico los roles que vienen desmarcados del form para borrarlos
        foreach($user->roles as $rol_user){
            if(!in_array($rol_user->nombre,$roles)){
                $user->roles()->detach(Rol::where(['id' => $rol_user->id])->first());
                session()->forget($rol_user->nombre);
            }
        }

        // Si el rol que viene en el form ya lo tiene no lo crea y pasa al siguiente
        foreach ($roles as $key => $rol) {
            if(!$user->hasRole($rol)){
                $user->roles()->attach(Rol::where(['nombre' => $rol])->first());
                session([$rol=>$rol]);
            }
        }

        return redirect()->route('usuarios.admin')->with([
            'message' => 'Rol cambiado!'
        ]);
    }

    public function cambiar_sedes(Request $request, $id)
    {
        $user = User::find($id);
        $sedes = $request->sedes;

        foreach($user->sedes as $sede_user){
            if(!in_array($sede_user->id,$sedes)){
                $user->sedes()->detach(Sede::where(['id' => $sede_user->id])->first());
            }
        }

        // Si el rol que viene en el form ya lo tiene no lo crea y pasa al siguiente
        foreach ($sedes as $key => $sede) {
            if($user->hasSede($sede)){
                $sede = null;
            }
            if ($sede) {
                $user->sedes()->attach(Sede::where(['id' => $sede])->first());
            }
        }

        return redirect()->route('usuarios.admin')->with([
            'message' => 'Sede cambiada!'
        ]);
    }

    public function crear_usuario_alumno($alumno_id)
    {
        $alumno = Alumno::find($alumno_id);

        if($alumno->user_id){
            return redirect()->route('alumno.detalle',[
                'id' => $alumno->id
            ])->with([
                'mensaje_error' => 'El alumno, ya tiene un usuario creado'
            ]);
        }

        $data = [
            'email' => $alumno->email,
            'username' => $alumno->dni,
            'nombre' => $alumno->nombres,
            'apellido' => $alumno->apellidos,
            'telefono' => $alumno->telefono,
            'password' => Hash::make($alumno->dni)
        ];


        $user = User::create($data);
        $user->roles()->attach(Rol::where('nombre', 'alumno')->first());

        $alumno->user_id = $user->id;
        $alumno->update();

        Mail::to($alumno->email)->send(new MatriculacionUser($alumno));

        return redirect()->route('alumno.detalle',[
            'id' => $alumno->id
        ])->with([
            'mensaje_exitoso' => 'El usuario para el alumno '.$alumno->nombres.' '.$alumno->apellidos.' se ha creado exitosamente.'
        ]);

    }
}
