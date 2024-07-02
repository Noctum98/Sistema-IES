<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\LibroDigital;
use App\Models\MasterMateria;
use App\Models\Materia;
use App\Models\Regimen;
use App\Models\Resoluciones;
use App\Models\Sede;
use App\Services\AlumnoService;
use App\Services\CicloLectivoService;
use Illuminate\Http\Request;

class ZTestController extends Controller
{

    function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin');


    }

    public function getActions(string $name)
    {
        $resolucion = Resoluciones::with('carreras.materias')
            ->where('id', $name)
            ->get();

        foreach ($resolucion as $resoluciones) {
            foreach ($resoluciones->carreras as $carreras) {
                foreach ($carreras->materias as $materia) {
                    $data = [];

                    /** @var Materia $materia */
                    $data['name'] = $materia->nombre;
                    $data['year'] = $materia->año;
                    $data['field_stage'] = $materia->etapa_campo;
                    $data['delayed_closing'] = $materia->cierre_diferido;
                    $data['resoluciones_id'] = $resoluciones->id;
                    $data['regimen_id'] = $this->getRegimen($materia->regimen);

                    $mm = MasterMateria::where('name', $data['name'])->first();

                    if (!$mm) {

                        $mm = MasterMateria::create($data);

                    }

                    $materia->master_materia_id = $mm->id;
                    $materia->save();
                }
            }
        }

        return $resolucion;
    }

    public function getRegimen(string $regimen = null)
    {

        switch ($regimen) {
            case Materia::ANUAL:
                $id = Regimen::where(['identifier' => 'anual'])->first()->id;
                break;
            case Materia::PRI_SEM:
                $id = Regimen::where(['identifier' => 'sem_1'])->first()->id;
                break;
            case Materia::SEC_SEM:
                $id = Regimen::where(['identifier' => 'sem_2'])->first()->id;
                break;
            default:
                $id = Regimen::where(['identifier' => 'anual'])->first()->id;
        }

        return $id;

    }

    public function cargaLibros()
    {
        $libros = Libro::all();
        $user = auth()->user();

        $data = [];
        $data['user_id'] = $user->id;

        /**
         * 'number' => 'required|numeric|min:0|max:4294967295',
         * 'romanos' => 'required|string|min:1|max:191',
         * 'resoluciones_id' => 'required',
         * 'fecha_inicio' => 'nullable|string|min:0',
         * 'sede_id' => 'required',
         * 'libro_papel_id' => 'nullable|exist:libro_papel,id',
         * 'operador_id' => 'nullable',
         * 'observaciones' => 'nullable|string|min:1|max:191',
         */


        foreach ($libros as $libro) {
            /** @var Libro $libro */
            $resolucion_id = $libro->mesa->materia->masterMateria->resoluciones->id;
            $numero = $libro->numero;
            $folio = $libro->folio;

            $libroDigital = LibroDigital::where(
                [
                    'resoluciones_id' => $resolucion_id,
                    'number' => $numero,

                ]
            )->first();

            if (!$libroDigital)

                $libroDigital = LibroDigital::create([

                ]);


        }


    }


}



