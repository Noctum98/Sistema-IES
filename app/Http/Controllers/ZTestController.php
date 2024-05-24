<?php

namespace App\Http\Controllers;

use App\Models\MasterMateria;
use App\Models\Materia;
use App\Models\Regimen;
use App\Models\Resoluciones;
use Illuminate\Http\Request;

class ZTestController extends Controller
{
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


}



