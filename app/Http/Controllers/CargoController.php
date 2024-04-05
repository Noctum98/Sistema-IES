<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Materia;
use App\Models\Sede;
use App\Models\TipoMateria;
use App\Models\User;
use App\Services\CargoService;
use App\Services\CarreraService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CargoController extends Controller
{
    protected $carreraService;
    private $cargoService;

    /**
     * @param CarreraService $carreraService
     * @param CargoService $cargoService
     */
    public function __construct(
        CarreraService $carreraService,
        CargoService $cargoService
    ) {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-coordinador');
        $this->carreraService = $carreraService;
        $this->cargoService = $cargoService;
    }

    public function index(Request $request)
    {

        $user_id = Auth::user()->id;
        $search = $request->input('busqueda');
        if ($search) {
            $cargos = $this->cargoService->buscador($request, true);
        } else {

            /**
             * Si el rol es coordinador puede ver todos los cargos de las materias asignadas
             */
            if (Session::has('coordinador')) {
                $cargos = Cargo::whereHas('materias', function ($query) use ($user_id) {
                    return $query->whereHas('carrera', function ($query) use ($user_id) {
                        return $query->whereHas('users', function ($query) use ($user_id) {
                            return $query->where('users.id', $user_id);
                        });
                    });
                })->paginate(30);
            } else {
                $cargos = Cargo::orderBy('updated_at', 'DESC')->paginate(10);
            }


        }

        $carreras = $this->carreraService->modulares();
        $sedes = Sede::all();

        return view('cargo.admin', [
            'cargos' => $cargos,
            'carreras' => $carreras,
            'sedes' => $sedes
        ]);
    }

    public function show($id)
    {
        $users = User::whereHas('roles', function ($query) {
            return $query->where('nombre', 'profesor');
        })->get();

        $cargo = Cargo::find($id);
        $materias = Materia::where('carrera_id', $cargo->carrera_id)->get();

        return view('cargo.detail', [
            'cargo' => $cargo,
            'materias' => $materias,
            'users' => $users,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->getValidate($request);

        $cargo = Cargo::create($request->all());

        return redirect()->route('cargo.admin');
    }

    public function vista_editar(Cargo $id)
    {
        $carreras = $this->carreraService->modulares();
        $tipo_cargos = TipoMateria::all();

        return view('cargo.edit', [
            'cargo' => $id,
            'carreras' => $carreras,
            'tipo_cargos' => $tipo_cargos
//            'personal'  => $personal
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function editar(Cargo $cargo, Request $request): RedirectResponse
    {
        $this->getValidate($request);


        $cargo->carrera_id = $request->input('carrera_id');
        $cargo->update($request->all());

        return redirect()->route('cargo.show', ['id' => $cargo->id])->with([
            'message' => 'Datos editados correctamente!',
        ]);
    }

    public function agregarModulo(Request $request): RedirectResponse
    {
        $cargo = Cargo::find($request['cargo_id']);
        $cargo->materias()->attach(Materia::find($request['materia']));

        return redirect()->route('cargo.show', $cargo->id);
    }

    public function ponderarCargo(Request $request): JsonResponse
    {
        $cargo = Cargo::find($request['cargo_id']);
        $materia = Materia::find($request['materia_id']);
        $porcentaje = $request['porcentaje'] ?? null;
        $code = 404;
        if ($cargo && $materia && $porcentaje) {
            $cargo_materia = CargoMateria::where([
                'cargo_id' => $cargo->id,
                'materia_id' => $materia->id,
            ]);
            $cargo_materia->update(["ponderacion" => $porcentaje]);
            $code = 200;
        }
        $total_modulo = $this->getTotalModulo($materia);

        $data = [$porcentaje, $total_modulo];

        return response()->json($data, $code);
    }

    public function getPonderarCargo(Request $request): JsonResponse
    {
        $cargo = Cargo::find($request['cargo_id']);
        $materia = Materia::find($request['materia_id']);
        $porcentaje = '0';

        if ($cargo && $materia) {
            $porcentaje = $this->cargoService->getPonderacion($cargo->id, $materia->id);
        }

        return response()->json($porcentaje, 200);
    }

    public function agregarUser(Request $request): RedirectResponse
    {
        $cargo = Cargo::find($request['cargo_id']);

        $cargo->users()->attach(User::find($request['user_id']));

        return redirect()->route('cargo.show', $cargo->id);
    }

    public function deleteUser(Request $request, $cargo_id): RedirectResponse
    {
        $cargo = Cargo::find($cargo_id);
        $cargo->users()->detach(User::find($request['user_id']));

        return redirect()->route('cargo.show', $cargo->id);
    }

    public function deleteModulo(Request $request, $cargo_id): RedirectResponse
    {
        $cargo = Cargo::find($cargo_id);
        $cargo->materias()->detach(Materia::find($request['materia_id']));

        return redirect()->route('cargo.show', $cargo->id);
    }

    public function selectCargos($id): JsonResponse
    {
        $cargos = Cargo::select('nombre', 'id')->where('carrera_id', $id)->get();

        return response()->json($cargos, 200);
    }

    /**
     * @param Cargo $cargo Recibe un Model cargo
     * @return RedirectResponse Redirecciona al index de cargo
     */
    public function destroy(Cargo $cargo): RedirectResponse
    {
        if ($cargo->users()) {
            $cargo->users()->detach();
        }

        if ($cargo->materias()) {
            $cargo->materias()->detach();
        }

        $cargo->delete();

        return redirect()->route('cargo.admin')
            ->with([
                'cargo_deleted' => sprintf('El cargo %s fue eliminado exitosamente', $cargo->nombre),
            ]);
    }

    /**
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    protected function getValidate(Request $request): void
    {
        $validate = $this->validate($request, [
            'nombre' => ['required'],
            'carrera_id' => ['required', 'numeric'],
        ]);
    }

    /**
     * @param $materia
     * @return int|mixed
     */
    public function getTotalModulo($materia)
    {
        $total_modulo = 0;
        $cargos_modulo = CargoMateria::where([
            'materia_id' => $materia->id,
        ])->get();

        foreach ($cargos_modulo as $cm) {
            $total_modulo = $cm->ponderacion + $total_modulo;

        }

        return $total_modulo;
    }

    public function agregarTipoCargo(Cargo $cargo, Request $request): RedirectResponse
    {

        $cargo = Cargo::find($request['cargo_id']);
        $tipoCargo = TipoMateria::find($request['tipo_cargo']);
        if ($tipoCargo) {
            $cargo->tipo_materia_id = $tipoCargo->id;
            $cargo->update();
        }

        return redirect()->route('cargo.show', $cargo->id);
    }


}
