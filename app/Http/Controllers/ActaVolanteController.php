<?php

namespace App\Http\Controllers;

use App\Models\ActaVolante;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\MesaAlumno;
use App\Models\Sede;
use App\Services\MesaService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ActaVolanteController extends Controller
{
    protected $userService;
    protected $mesaService;
    public function __construct(
        UserService $userService,
        MesaService $mesaService
    ) {
        $this->middleware('app.roles:admin-coordinador-seccionAlumnos-regente-profesor');
        $this->userService = $userService;
        $this->mesaService = $mesaService;
    }

    public function index(Request $request)
    {
        $mesas = $this->userService->mesasPresidente();

        return view('mesa.acta_volante.index', [
            'mesas' => $mesas
        ]);
    }

    public function show(Request $request, $mesa_id)
    {
        $mesa = Mesa::find($mesa_id);

        if ($mesa->instancia->tipo == 1) {
            $inscripciones = MesaAlumno::where([
                'instancia_id' => $mesa->instancia_id,
                'materia_id' => $mesa->materia_id,
                'estado_baja' => 0
            ])->get();

            $this->mesaService->verificarInscripcionesEspeciales($inscripciones, $mesa->materia, $mesa->instancia);
        }

        return view('mesa.acta_volante.show', [
            'mesa' => $mesa,
        ]);
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'nota_escrito' => ['required'],
            'nota_oral' => ['required'],
        ]);
        $request = $this->verificar_nota($request);

        if ($request['error']) {
            $alerta = ['alert_danger' => 'Error en los datos enviados'];
        } else {
            $acta_volante = ActaVolante::create($request->all());

            $alerta = ['alert_success' => 'Se han colocado correctamente las notas'];
        }


        return redirect()->back()->with($alerta);
    }

    public function update(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'nota_escrito' => ['required'],
            'nota_oral' => ['required'],
        ]);

        $request = $this->verificar_nota($request);

        if ($request['error']) {
            $alerta = ['alert_danger' => 'Error en los datos enviados'];
        } else {
            $acta_volante = ActaVolante::find($id);

            $acta_volante->update($request->all());

            $alerta = ['alert_success' => 'Se han editado correctamente las notas.'];
        }
        return redirect()->back()->with($alerta);
    }

    private function verificar_nota(Request $request)
    {
        $suma = 0;
        $contador = 0;
        if ($request['ausente'] && $request['ausente'] == '1') {
            $request['nota_escrito'] = -1;
            $request['nota_oral'] = -1;
            $request['promedio'] = -1;
        } else {
            if (trim($request['nota_escrito']) != '-') {
                $suma = $suma + (int) $request['nota_escrito'];
                $contador++;
            }

            if (trim($request['nota_oral']) != '-') {
                $suma = $suma + (int) $request['nota_oral'];
                $contador++;
            }

            if ($contador > 0 && $suma > 0) {
                $request['promedio'] = $suma / $contador;
                $request['promedio'] = round($request['promedio'], 0, PHP_ROUND_HALF_UP);
            } else {
                $request['error'] = true;
            }
        }

        return $request;
    }

    public function resumenInstancia(Request $request, $instancia_id)
    {
        $sedes = Sede::all();
        $carrerasInscriptos = [];

        foreach($sedes as $sede) {
            foreach($sede->carreras as $carrera) {
                $actasVolantesCount = ActaVolante::whereHas('materia', function ($query) use ($carrera, $instancia_id) {
                    return $query->where('carrera_id', $carrera->id);
                })
                ->where('instancia_id', $instancia_id)
                ->count();

                $actasVolantesCountA = ActaVolante::whereHas('materia', function ($query) use ($carrera) {
                    return $query->where('carrera_id', $carrera->id);
                })
                ->where('instancia_id', $instancia_id)
                ->where('promedio', '>', '3')
                ->count();

                $carrerasInscriptos[$carrera->id] =  $actasVolantesCount;
                $carrerasInscriptos[$carrera->id . '-aprobados'] = $actasVolantesCountA;
            }
        }

        return view('estadistica.mesas',[
            'sedes' => $sedes,
            'carrerasInscriptos' => $carrerasInscriptos
        ]);
    }

    public function notasAnteriores(Request $request, $materia_id, $alumno_id)
    {

        $materia = Materia::find($materia_id);

        $actas = $materia->getActasVolantesConLibro($alumno_id);

        $actas = $actas->sortByDesc('created_at');

        $result = $actas->map(function($acta){
            return [
                'nota' => $acta->promedio == -1 ? 'A': $acta->promedio, // Change this to your actual field name for note.
                'fecha' => $acta->mesaAlumno()->first()->fechaMesa(), // Change this to your actual field name for date.
            ];
        });



       return json_encode($result) ;



    }
}

