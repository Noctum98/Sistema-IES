<?php

namespace App\Http\Controllers;

use App\Exports\AlumnosMateriaExport;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Personal;
use App\Models\Materia;
use App\Models\Proceso;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MateriaController extends Controller
{
    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente-coordinador-seccionAlumnos');
    }

    // Vistas

    public function vista_admin(int $carrera_id)
    {
        $carrera = Carrera::find($carrera_id);
        $materias = Materia::where('carrera_id', $carrera_id)->orderBy('año')->get();

        return view('materia.admin', [
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

        $materia = new Materia();
        $materia->nombre = $request->input('nombre');
        $materia->año = (int)$request->input('año');
        $materia->carrera_id = $carrera_id;

        $materia->save();

        return redirect()->route('materia.admin', ['carrera_id' => $carrera_id]);
    }

    public function editar(int $id, Request $request)
    {
        $validate = $this->validate($request, [
            'nombre' => ['required'],
            'año' => ['required', 'numeric', 'max:3'],
        ]);
        
        $materia = Materia::find($id);
        $materia->nombre = $request->input('nombre');
        $materia->año = (int)$request->input('año');
        $materia->personal_id = (int)$request->input('personal');
        $materia->correlativa = $request->input('correlativa');

        $materia->update();

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
}
