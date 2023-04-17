<?php

namespace App\Http\Controllers;

use App\Exports\AlumnosMateriaExport;
use App\Models\User;
use App\Services\MateriaService;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Estados;
use App\Models\Personal;
use App\Models\Materia;
use App\Models\Proceso;
use App\Services\CicloLectivoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MateriaController extends Controller
{
    /**
     * @var MateriaService
     */
    private $materiaService;
    protected $cicloLectivoService;


    /**
     * @param MateriaService $materiaService
     */
    function __construct(
        MateriaService $materiaService,
        CicloLectivoService $cicloLectivoService
    )
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente-coordinador-seccionAlumnos');
        $this->materiaService = $materiaService;
        $this->cicloLectivoService = $cicloLectivoService;
    }

    // Vistas

    public function vista_admin(int $carrera_id)
    {
        $ruta = 'materia.admin';
        $carrera = Carrera::find($carrera_id);
        $materias = Materia::where('carrera_id', $carrera_id)->orderBy('año')->get();

        if ($carrera->tipo == 'modular' || $carrera->tipo == 'modular2') {
            $ruta = 'materia.admin-modular';
        }

        $ciclos_lectivos = $this->cicloLectivoService->getCicloInicialYActual();

        return view($ruta, [
            'carrera' => $carrera,
            'materias' => $materias,
            'ciclos_lectivos' => $ciclos_lectivos
        ]);
    }

    public function vista_crear(int $carrera_id)
    {
        $carrera = Carrera::find($carrera_id);
        $personal = Personal::where('sede_id', $carrera->sede_id)->get();
        $materias = Materia::where('carrera_id', $carrera_id)->get();

        return view('materia.create', [
            'carrera' => $carrera,
            'personal' => $personal,
            'materias' => $materias,
        ]);
    }

    public function vista_editar(int $id)
    {
        $materia = Materia::find($id);
        $personal = Personal::where('sede_id', $materia->carrera->sede_id)->get();
        $materias = Materia::where('carrera_id', $materia->carrera_id)->get();

        return view('materia.edit', [
            'materia' => $materia,
            'personal' => $personal,
            'materias' => $materias,
        ]);
    }

    // Funcionalidades

    public function crear(int $carrera_id, Request $request)
    {
        $validate = $this->validate($request, [
            'nombre' => ['required'],
            'año' => ['required', 'numeric', 'max:3'],
            'personal' => ['numeric'],
        ]);

        $request['carrera_id'] = $carrera_id;

        $materia = Materia::create($request->all());

        return redirect()->route('materia.admin', ['carrera_id' => $carrera_id]);
    }

    public function editar(int $id, Request $request)
    {
        $validate = $this->validate($request, [
            'nombre' => ['required'],
            'año' => ['required', 'numeric', 'max:3'],
            'regimen' => ['required']
        ]);

        $materia = Materia::find($id);
        $materia->update($request->all());


        return redirect()->route('materia.editar', ['id' => $id])->with([
            'message' => 'Materia editada correctamente!',
        ]);
    }

    public function selectMaterias($id)
    {
        $materias = Materia::select('nombre', 'id')->where('carrera_id', $id)->get();

        return response()->json($materias, 200);
    }

    public function descargar_planilla($id)
    {
        $pprocesos = Proceso::select('procesos.*', 'alumnos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->join('materias', 'materias.id', 'procesos.materia_id')
            ->where('materias.id', $id)
            ->where('procesos.ciclo_lectivo',date('Y'))
            ->orderBy('alumnos.apellidos', 'asc')
            ->get();

        $materia = Materia::find($id);

        if ($pprocesos) {
            return Excel::download(
                new AlumnosMateriaExport($pprocesos),
                'Alumnos ' . $materia->nombre . '.xlsx'
            );
        } else {
            return redirect()->route('materia.admin', $materia->carrera->id)->with([
                'error_procesos' => 'No hay alumnos en esa materia',
            ]);
        }
    }

    public function cierre_tradicional(Request $request, $materia_id, $comision_id = null)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id);


        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }

        $procesos = $procesos->get();

        $estadoNoRegular = Estados::where('identificador',2)->first();
        foreach($procesos as $proceso)
        {
            if(!$proceso->estado_id)
            {
                $proceso->estado_id = $estadoNoRegular->id;
            }

            $proceso->cierre = true;
            $proceso->update();
        }

        return redirect()->back();
    }

    public function vista_listado()
    {
        $materias = Materia::orderBy(
            'nombre',
            'Asc',

        )->orderBy('año', 'Asc')->paginate(10);
        return view('materia.listado', [
            'materias' => $materias,
        ]);
    }

    public function vistaMateria(int $instancia, $comision = null)
    {
        $user = Auth::user();
        /** @var  User $user */
        $materias = $this->getIdsByModel($user->materias()->get());

        $materia = new Materia();
        $mesas = $materia->mesasByMateria($instancia, $materias, $comision);

        return view('mesa.components.vista_materia')->with([
            'mesas' => $mesas,
            'instancia' => $instancia,
            'comision' => $comision
        ]);
    }

    private function getIdsByModel($models): array
    {
         $ids = [];

         foreach ($models as $model){
             array_push($ids, $model->id) ;
         }

         return$ids;

    }
}
