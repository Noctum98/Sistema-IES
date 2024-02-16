<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Carrera;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = "/login";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'telefono' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'telefono' => $data['telefono'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol' => $data['roles'][0] ? 'rol_'.$data['roles'][0] : '',
        ]);

        foreach($data['roles'] as $role)
        {
            $user->roles()->attach(Rol::where('nombre', $role)->first());
        }

        return $user;
    }

    public function register(Request $request)
    {
        $user = $this->registerEvent($request);

        return redirect()->route('usuarios.detalle',[
            'id' => $user->id,
        ]);
    }

    public function registerAlumno(Request $request)
    {
        $user = $this->registerEvent($request);

        $request['dni'] = $request['username'];
        $request['nombres'] = $request['nombre'];
        $request['apellidos'] = $request['apellido'];
        $request['user_id'] = $user->id;
        $alumno = Alumno::create($request->all());

        $request['alumno_id'] = $alumno->id;
        $inscripcion = AlumnoCarrera::create($request->all());

        return redirect()->route('alumno.carrera',['carrera_id'=>$inscripcion->carrera_id, 'ciclo_lectivo' => $inscripcion->ciclo_lectivo]);
    }

    /**
     * @return Application|Factory|View
     */
    public function showRegistrationForm()
    {
        $auth = Auth::user();
        $roles = Rol::select('nombre', 'id', 'descripcion')->where('tipo', 0)->get();
        if ($auth->hasAnyRole('coordinador')) {
            $roles = Rol::select('nombre', 'id', 'descripcion')->where('nombre', 'profesor')->orWhere('nombre','planillas')->get();
        }

        return view('auth.register', compact('roles'));
    }

    public function showRegistrationAlumnosForm(Request $request,$carrera_id)
    {
        $user = Auth::user();
        $carreras = $user->carreras;

        if(Session::has('admin') || Session::has('regente'))
        {
            $carreras = Carrera::orderBy('sede_id','asc')->get();
        }

        $data = [
            'roles' => Rol::select('nombre', 'id', 'descripcion')->where('nombre', 'alumno')->get(),
            'carreraSelected' => Carrera::find($carrera_id),
            'carreras' => $carreras
        ];

        return view('auth.register-alumnos',$data);
    }

    private function registerEvent($request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        event(new Registered($user));

        return $user;
    }
}
