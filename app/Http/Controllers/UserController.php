<?php

namespace App\Http\Controllers;

use App\Mail\MatriculacionUser;
use App\Models\Alumno;
use App\Models\Cargo;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\Sede;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\SedeUser;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    protected $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->middleware('app.roles:admin-usuarios-coordinador-seccionAlumnos-regente', ['only' => ['vista_admin', 'set_roles', 'cambiar_sedes', 'crear_usuario_alumno']]);
        $this->userService = $userService;
    }

    // Controlador de administration de usuarios

    public function vista_admin(Request $request)
    {
        $search = $request->input('search');
        if (trim($search) != '') {
            $auth = Auth::user();
            $rol = null;
            if (Session::get('coordinador')) {
                $rol = 'profesor';
            }
            $users = $this->userService->buscador($search, $rol);
        } else {
            $users = User::usersPersonal();
        }


        $sedes = Sede::select('nombre', 'id')->get();
        $roles_primarios = Rol::select('nombre', 'id', 'descripcion')->where('tipo', 0)->get();
        $roles_secundarios = Rol::select('nombre', 'id', 'descripcion')->where('tipo', 1)->get();

        return view('user.admin', [
            'users' => $users,
            'sedes' => $sedes,
            'roles_primarios' => $roles_primarios,
            'roles_secundarios' => $roles_secundarios,
        ]);
    }

    public function vista_listado($rol, $busqueda = null)
    {
        if ($busqueda) {

            $lista = $this->userService->buscador($busqueda, $rol);
        } else {
            $lista = User::whereHas('roles', function ($query) use ($rol) {
                return $query->where('nombre', $rol);
            })->paginate(20);
        }
        $rolListado = Rol::where(['descripcion' => $rol])->first();



        return view('user.listado', [
            'lista' => $lista,
            'rolListado' => $rolListado
        ]);
    }

    public function vista_detalle($id)
    {
        $auth = User::find(Auth::user()->id);
        $user = User::find($id);

        if (Session::get('admin')) {
            $sedes = Sede::all();
        } else {
            $sedes = $auth->sedes ?? [];
        }

        if (Session::get('admin')) {
            $carreras = Carrera::all();
        } else {
            $carreras = $auth->carreras;
            $carreras_id = [];
            foreach ($carreras as $carrera) {
                $carreras_id[] = $carrera->id;
            }
        }

        if (Session::get('admin')) {
            $materias = Materia::all();
        } else {
            $materias = Materia::select('materias.id')
                ->join('carreras', 'carreras.id', 'materias.carrera_id')
                ->where(function ($query) {
                    return $query
                        ->whereNull('carreras.tipo')
                        ->orWhere('carreras.tipo', '=', 'tradicional')
                        ->orWhere('carreras.tipo', '=', 'tradicional2');
                })
                ->whereIn('carreras.id', $carreras_id)
                ->orderBy('materias.nombre', 'asc')
                ->get();
        }
        if (Session::get('admin')) {
            $cargos = Cargo::all();
        } else {
            $cargos = Cargo::select('cargos.id')
                ->join('carreras', 'carreras.id', 'cargos.carrera_id')
                ->whereIn('carreras.id', $carreras_id)
                ->where(function ($query) {
                    return $query
                        ->where('carreras.tipo', '=', 'modular')
                        ->orWhere('carreras.tipo', '=', 'modular2');
                })
                ->orderBy('cargos.nombre', 'asc')
                ->get();
        }

        if (Session::has('coordinador') && !Session::has('admin')) {
            $roles_primarios = Rol::select('nombre', 'id', 'descripcion')
                ->where('nombre', 'profesor')
                ->orWhere('nombre', 'planillas')
                ->get();

            $roles_secundarios = null;
        } else {
            $roles_primarios = Rol::select('nombre', 'id', 'descripcion')->where('tipo', 0)->get();
            $roles_secundarios = Rol::select('nombre', 'id', 'descripcion')->where('tipo', 1)->get();
        }

        return view('user.detail', [
            'user' => $user,
            'sedes' => $sedes,
            'carreras' => $carreras,
            'cargos' => (bool)count($cargos) > 0,
            'materias' => (bool)count($materias) > 0,
            'roles_primarios' => $roles_primarios,
            'roles_secundarios' => $roles_secundarios,
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function vista_mis_datos()
    {
        /** @var User $auth */
        $auth = Auth::user();
        $sedes = $auth->sedes;
        $carreras = $auth->carreras;
        $materias = $auth->materias;
        $cargos = $auth->cargos;
        $nivelUsuario = $auth->roles->where('tipo', 0);

        return view('user.mi_detail', [
            'user' => $auth,
            'sedes' => $sedes,
            'carreras' => $carreras,
            'cargos' => $cargos,
            'materias' => $materias,
            'nivel_usuario' => $nivelUsuario,
        ]);
    }

    public function vista_editar()
    {
        $user = Auth::user();

        return view('user.edit', [
            'user' => $user,
        ]);
    }

    public function editar(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validate = $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($request->all());

        return redirect()->route('usuarios.editar', [
            'user' => $user,
        ])->with([
            'datos_editados' => 'Los datos personales han sido actualizados',
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user->roles()) {
            $user->roles()->detach();
        }

        if ($user->sedes()) {
            $user->sedes()->detach();
        }

        if ($user->carreras()) {
            $user->carreras()->detach();
        }

        if ($user->materias()) {
            $user->materias()->detach();
        }

        $user->delete();

        return redirect()->route('usuarios.admin')->with([
            'user_deleted' => 'El usuario eliminado exitosamente',
        ]);
    }

    public function activarDesactivar(Request $request, $id)
    {
        $user = User::find($id);

        if ($user->activo) {
            $user->activo = false;
        } else {
            $user->activo = true;
        }

        $user->update();

        return response()->json($user, 200);
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

        return redirect()->back()->with([
            'contraseña_nueva' => 'La contraseña ha sido actualizada',
        ]);
    }

    public function set_roles(Request $request, $id)
    {
        $user = User::find($id);
        $roles = $request->roles;

        // Verifico los roles que vienen desmarcados del form para borrarlos
        foreach ($user->roles as $rol_user) {
            if (!in_array($rol_user->nombre, $roles)) {
                $user->roles()->detach(Rol::where(['id' => $rol_user->id])->first());
                session()->forget($rol_user->nombre);
            }
        }

        // Si el rol que viene en el form ya lo tiene no lo crea y pasa al siguiente
        foreach ($roles as $key => $rol) {
            if (!$user->hasRole($rol)) {
                $user->roles()->attach(Rol::where(['nombre' => $rol])->first());
                session([$rol => $rol]);
            }
        }

        return redirect()->route('usuarios.detalle', $user->id)->with([
            'message' => 'Rol cambiado!',
        ]);
    }

    public function cambiar_sedes(Request $request, $id)
    {
        $user = User::find($id);
        $sedes = $request->sedes;

        foreach ($user->sedes as $sede_user) {
            if (!in_array($sede_user->id, $sedes)) {
                $user->sedes()->detach(Sede::where(['id' => $sede_user->id])->first());
            }
        }

        // Si el rol que viene en el form ya lo tiene no lo crea y pasa al siguiente
        foreach ($sedes as $key => $sede) {
            if ($user->hasSede($sede)) {
                $sede = null;
            }
            if ($sede) {
                $user->sedes()->attach(Sede::where(['id' => $sede])->first());
            }
        }

        return redirect()->route('usuarios.detalle', $user->id)->with([
            'message' => 'Sede cambiada!',
        ]);
    }

    public function setMateriasUser(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $carrera = Carrera::find($request['carrera']);
        $materia = Materia::find($request['materia']);

        if ($user->hasSede($carrera->sede_id)) {
            $user->carreras()->attach($carrera);
            $user->materias()->attach($materia);
        } else {
            return redirect()->route('usuarios.detalle', $user->id)->with(
                ['error_sede' => 'El usuario no pertenece a esa sede']
            );
        }

        return redirect()->route('usuarios.detalle', $user->id)->with(
            ['carrera_success' => 'Se han añadido la materia y carrera al usuario']
        );
    }

    public function crear_usuario_alumno($alumno_id)
    {
        $alumno = Alumno::find($alumno_id);

        if ($alumno->aprobado) {
            return redirect()->route('alumno.detalle', [
                'id' => $alumno->id,
            ])->with([
                'alert_warning' => 'El alumno, ya tiene esta aprobado',
            ]);
        }else{
            $alumno->aprobado = true;
        }

        if (!$alumno->user_id) {
            $data = [
                'email' => $alumno->email,
                'username' => $alumno->dni,
                'nombre' => $alumno->nombres,
                'apellido' => $alumno->apellidos,
                'telefono' => $alumno->telefono,
                'password' => Hash::make($alumno->dni),
            ];

            $user_exists = User::where('email', $alumno->email)
                ->orWhere('username', $alumno->dni)->withTrashed()->first();
            
            if ($user_exists) {
                if($user_exists->hasRole('profesor') && (!$user_exists->hasRole('coordinador') && !$user_exists->hasRole('seccionAlumnos')))
                {
                    $user = $user_exists;
                }else{
                    $alumno_verification = Alumno::where('user_id',$user_exists->id)->first();

                    if($alumno_verification)
                    {
                        return redirect()->back()->with(['alert_danger' => 'Ya existe un usuario con este email o nombre de usuario']);
                    }else{
                        $user = $user_exists;
                    }
                }
            } else {
                $user = User::create($data);
            }

            $user->roles()->attach(Rol::where('nombre', 'alumno')->first());

            $alumno->user_id = $user->id;
        }

        $alumno->update();

        // Mail::to($alumno->email)->send(new MatriculacionUser($alumno));

        return redirect()->route('alumno.detalle', [
            'id' => $alumno->id,
        ])->with([
            'mensaje_exitoso' => 'El usuario para el alumno ' . $alumno->nombres . ' ' . $alumno->apellidos . ' se ha creado exitosamente.',
        ]);
    }

    public function regenerar_contra(Request $request, $id)
    {
        $user = User::find($id);
        $new_password = Hash::make('12345678');
        $user->password = $new_password;
        $user->update();

        return response()->json(['status' => 'success']);
    }

    public function getUsuarioByUsernameOrNull($busqueda)
    {
        return response()->json($this->userService->buscadorUsuario($busqueda), 200);
    }
}
