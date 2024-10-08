<?php

namespace App\Http\Controllers;

use App\Exports\AlumnosMateriaExport;
use App\Models\MasterMateria;
use App\Models\MateriasCorrelativa;
use App\Models\MateriasCorrelativasCursado;
use App\Models\User;
use App\Services\MateriaService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Estados;
use App\Models\Personal;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\Regimen;
use App\Models\TipoMateria;
use App\Services\ProcesoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MateriaController extends Controller
{
    /**
     * @var MateriaService
     */
    private $materiaService;
    private $procesoService;

    /**
     * @param MateriaService $materiaService
     * @param ProcesoService $procesoService
     */
    function __construct(MateriaService $materiaService, ProcesoService $procesoService)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente-coordinador-seccionAlumnos-areaSocial');
        $this->materiaService = $materiaService;
        $this->procesoService = $procesoService;
    }

    // Vistas

    /**
     * @param int $carrera_id
     * @return Application|Factory|View
     */
    public function vista_admin(int $carrera_id)
    {
        $ruta = 'materia.admin';
        $carrera = Carrera::find($carrera_id);
        $materias = Materia::where('carrera_id', $carrera_id)->orderBy('año')->get();

        if ($carrera->tipo == 'modular' || $carrera->tipo == 'modular2') {
            $ruta = 'materia.admin-modular';
        }

        return view($ruta, [
            'carrera' => $carrera,
            'materias' => $materias,
        ]);
    }

    public function vista_crear(int $carrera_id)
    {
        $carrera = Carrera::find($carrera_id);
        $materias = Materia::where('carrera_id', $carrera_id)->get();


        $resoluciones = $carrera->resoluciones()->first();

        $masterMaterias = null;
        if($resoluciones){
            $masterMaterias = $resoluciones->masterMaterias;
        }

        return view('materia.create', [
            'carrera' => $carrera,
            'materias' => $materias,
            'masterMaterias' => $masterMaterias
        ]);
    }

    public function vista_editar(int $id)
    {
        $materia = Materia::find($id);
        $materias = Materia::where('carrera_id', $materia->carrera_id)->get();

        $carrera = Carrera::find($materia->carrera_id);
        $resoluciones = $carrera->resoluciones()->first();
        $tipo_materias = TipoMateria::all();
        $regimenes = Regimen::all();

        $masterMaterias = null;
        if($resoluciones){
            $masterMaterias = $resoluciones->masterMaterias->where('year', $materia->año);
        }

        return view('materia.edit', [
            'materia' => $materia,
            'materias' => $materias,
            'masterMaterias' => $masterMaterias,
            'tipo_materias' => $tipo_materias,
            'regimenes' => $regimenes
        ]);
    }

    // Funcionalidades

    public function crear(int $carrera_id, Request $request)
    {
        $validate = $this->validate($request, [
            'master_materia_id' => ['required'],
        ]);

        $request['carrera_id'] = $carrera_id;

        $request['correlativa'] = $request['correlativa'] ?? null;
        $request['correlativa_cursado'] = $request['correlativa_cursado'] ?? null;

        $mm = MasterMateria::find($request['master_materia_id'][0]);


        $request['nombre'] = $mm->name;
        $request['regimen'] = $request['regimen']?? $mm->regimen->name;
        $request['año'] = $mm->year;

        $request['etapa_campo'] = $mm->field_stage;
        $request['cierre_diferido'] = $mm->delayed_closing;
        $request['master_materia_id'] = $mm->id;

        $materia = Materia::create($request->all());

        return redirect()->route('materia.admin', ['carrera_id' => $carrera_id]);
    }

    public function editar(int $id, Request $request)
    {
        $input = $request->all();
        $correlativas = $input['correlativa'] ?? null;
        $correlativasCursado = $input['correlativa_cursado'] ?? null;
        $validate = $this->validate($request, [
            'nombre' => ['required'],
            'año' => ['required', 'numeric', 'max:3'],
            'regimen' => ['required']
        ]);

        

        $materia = Materia::find($id);
        $masterMateria = $materia->masterMateria;

        $materia->update($request->all());

        $materiasCorrelativa = MateriasCorrelativa::where([
            'materias_correlativas.materia_id' => $materia->id,
        ])->get();
        if ($materiasCorrelativa) {
            foreach ($materiasCorrelativa as $mater) {
                $mater->delete();
            }
        }
        if ($correlativas) {
            foreach ($correlativas as $correlativa) {
                MateriasCorrelativa::create([
                    'correlativa_id' => $correlativa,
                    'materia_id' => $materia->id,
                    'operador_id' => Auth::user()->id
                ]);
            }
        }

        $materiasCorrelativaCursado = MateriasCorrelativasCursado::where([
            'materias_correlativas_cursados.materia_id' => $materia->id,
        ])->get();
        if ($materiasCorrelativaCursado) {
            foreach ($materiasCorrelativaCursado as $materCursado) {
                $materCursado->delete();
            }
        }
        if ($correlativasCursado) {
            foreach ($correlativasCursado as $correlativaC) {
                MateriasCorrelativasCursado::create([
                    'previa_id' => $correlativaC,
                    'materia_id' => $materia->id,
                    'operador_id' => Auth::user()->id
                ]);
            }
        }

        if($request['tipo_unidad_curricular'] != $masterMateria->tipo_unidad_curricular_id)
        {
            
            $masterMateria->tipo_unidad_curricular_id = $request['tipo_unidad_curricular'];
        }

        /*
        if($request['regimen'])
        {
            $masterMateria->regimen_id = $request['regimen'];
        }
        */
        $masterMateria->update();

        return redirect()->route('materia.editar', ['id' => $id])->with([
            'message' => 'Materia editada correctamente!',
        ]);
    }

    public function selectMaterias($id)
    {
        $materias = Materia::select('nombre', 'id')->where('carrera_id', $id)->get();

        return response()->json($materias, 200);
    }

    /**
     * @param $idCarrera
     * @param $idAlumno
     * @param $ciclo_lectivo
     * @return JsonResponse
     */
    public function selectMateriasInscripto($idCarrera, $idAlumno, $ciclo_lectivo): JsonResponse
    {
        $materias = Materia::select('materias.nombre', 'materias.id')
            ->join('procesos', 'procesos.materia_id', 'materias.id')
            ->where('materias.carrera_id', $idCarrera)
            ->where('procesos.ciclo_lectivo', $ciclo_lectivo)
            ->where('procesos.alumno_id', $idAlumno)
            ->get();

        return response()->json($materias, 200);
    }

    public function descargar_planilla($id)
    {
        $pprocesos = Proceso::select('procesos.*', 'alumnos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->join('materias', 'materias.id', 'procesos.materia_id')
            ->where('materias.id', $id)
            ->where('procesos.ciclo_lectivo', date('Y'))
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

    public function cierre_tradicional(Request $request, $materia_id, $ciclo_lectivo, $comision_id = null)
    {
        $procesos = Proceso::select('procesos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->where('ciclo_lectivo', $ciclo_lectivo);


        if ($comision_id) {
            $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
                $query->whereHas('comisiones', function ($query) use ($comision_id) {
                    $query->where('comisiones.id', $comision_id);
                });
            });
        }

        $procesos = $procesos->get();

        $estadoNoRegular = Estados::where('identificador', 2)->first();

        foreach ($procesos as $proceso) {
            $procesoRepetido = $this->procesoService->verificarRepetido($proceso, $procesos);

            if (!$procesoRepetido) {
                return redirect()->back()->with([
                    'alert_danger' => 'El proceso del alumno ' . $proceso->alumno->getApellidosNombresAttribute() . ' está duplicado, debe unificar las notas en uno solo, y dejar vacío la que no corresponde, el sistema eliminará automaticamente el proceso sin notas ni asistencia.'
                ]);
            }
        }
        foreach ($procesos as $proceso) {

            if (!$proceso->estado_id) {
                $proceso->estado_id = $estadoNoRegular->id;
            }

            $proceso->cierre = true;
            $proceso->cierre_final = true;
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

        foreach ($models as $model) {
            array_push($ids, $model->id);
        }

        return $ids;

    }

    /**
     * @param Materia $materia
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function show(Materia $materia)
    {
        return view('materia.modal.content_show_modal')->with([
            'materia' => $materia,
        ]);
    }


}
