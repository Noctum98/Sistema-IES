<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Carrera;
use App\Models\Materia;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('app.roles:admin-regente');
    }

    public function vista_calificaciones(Request $request)
    {
        if($request->get('orden')){

               $carreras = Carrera::all()->sortBy($request->get('orden'),1);

        }else{
            $carreras = Carrera::all();
        }


        return view('admin.calificaciones.list', [
            'carreras'  => $carreras
        ]);
    }

    public function vista_calificaciones_materias(Request $request, Carrera $carrera)
    {
        $ruta = 'admin.calificaciones.materias';

        $materias = Materia::where('carrera_id', $carrera->id)->orderBy('año')->get();

        return view($ruta, [
            'carrera' => $carrera,
            'materias' => $materias,
        ]);
    }

    public function vista_calificaciones_cargos(Request $request, Materia $materia)
    {
        $ruta = 'admin.calificaciones.cargos';
//        $carrera = Carrera::find($carrera_id);
        $cargosMateria = CargoMateria::where('materia_id', $materia->id)->orderBy('ponderacion')->get();

//        if ($carrera->tipo == 'modular' || $carrera->tipo == 'modular2') {
//            $ruta = 'materia.admin-modular';
//        }

        $tieneTfi = false;
        foreach ($cargosMateria as $cargo){
            if($cargo->cargo->responsableTFI($materia->id)){
                $tieneTfi = true;
            }
        }

        return view($ruta, [
            'modulo' => $materia,
            'cargos' => $cargosMateria,
            'tieneTfi' => $tieneTfi
        ]);
    }
}
