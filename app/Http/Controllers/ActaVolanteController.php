<?php

namespace App\Http\Controllers;

use App\Models\ActaVolante;
use App\Models\Mesa;
use App\Models\MesaAlumno;
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
            
            $this->mesaService->verificarInscripcionesEspeciales($inscripciones,$mesa->materia,$mesa->instancia);
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
}
