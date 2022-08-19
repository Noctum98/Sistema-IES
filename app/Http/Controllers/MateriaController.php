<?php

namespace App\Http\Controllers;

use App\Exports\AlumnosMateriaExport;
use App\Services\MateriaService;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Personal;
use App\Models\Materia;
use App\Models\Proceso;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MateriaController extends Controller
{
    /**
     * @var MateriaService
     */
    private $materiaService;

    /**
     * @param MateriaService $materiaService
     */
    function __construct(MateriaService $materiaService)
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente-coordinador-seccionAlumnos');
        $this->materiaService = $materiaService;
    }

    // Vistas

    public function vista_admin(int $carrera_id)
    {
        $ruta = 'materia.admin';
        $carrera = Carrera::find($carrera_id);
        $materias = Materia::where('carrera_id', $carrera_id)->orderBy('año')->get();

        if($carrera->tipo == 'modular' || $carrera->tipo == 'modular2' )
        {
            $ruta = 'materia.admin-modular';
        }

        return view( $ruta, [
            'carrera' => $carrera,
            'materias' => $materias,
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
        $materias = Materia::select('nombre','id')->where('carrera_id',$id)->get();

        return response()->json($materias, 200);
    }

    public function descargar_planilla($id)
    {
        $pprocesos = Proceso::select('procesos.*', 'alumnos.*')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->join('materias', 'materias.id', 'procesos.materia_id')
            ->where('materias.id', $id)
            ->orderBy('alumnos.apellidos', 'asc')
            ->get();

        $materia = Materia::find($id);

        if ($pprocesos) {
            return Excel::download(
                new AlumnosMateriaExport($pprocesos),
                'Alumnos '.$materia->nombre.'.xlsx'
            );
        } else {
            return redirect()->route('materia.admin', $materia->carrera->id)->with([
                'error_procesos' => 'No hay alumnos en esa materia',
            ]);
        }


    }

    public function vista_listado()
    {
        $materias = Materia::orderBy(
            'nombre','Asc',

        )->orderBy('año', 'Asc') ->paginate(10);
        return view('materia.listado', [
            'materias' => $materias,
        ]);

    }

    public function cierre(Request $request,$materia_id,$comision_id = null)
    {
        $materia = Materia::find($materia_id);

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



        if($materia->cierre)
        {
            $materia->cierre = false;
        }else{
            $materia->cierre = true;
            $procesos = $procesos->update(['cierre'=>true]);

        }

        $materia->update();

        $datos = [
            'materia_id' => $materia_id
        ];

        if($comision_id)
        {
            $datos['comision_id'] = $comision_id;
        }

        return redirect()->route('proceso.listado',$datos);
    }
}
