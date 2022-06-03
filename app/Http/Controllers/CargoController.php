<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Sede;
use App\Models\User;
use App\Services\CargoService;
use App\Services\CarreraService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $search = $request->input('search');
        if (trim($search) != '') {
            $cargos = $this->cargoService->buscador($search);
        } else {
            $cargos = Cargo::orderBy('updated_at', 'DESC')->paginate(10);
        }


        $carreras = $this->carreraService->modulares();

        return view('cargo.admin', [
            'cargos' => $cargos,
            'carreras' => $carreras,
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

        return view('cargo.edit', [
            'cargo' => $id,
            'carreras' => $carreras,
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
                'cargo_deleted' => sprintf('El cargo %s fue eliminado exitosamente',$cargo->nombre)
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
}
