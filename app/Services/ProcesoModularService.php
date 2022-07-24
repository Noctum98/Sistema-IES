<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Cargo;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesoModular;


class ProcesoModularService
{

    public function crearProcesoModular($materia)
    {
        $pm_sin_vincular = $this->obtenerProcesosModularesNoVinculados($materia);
        $inicio = 0;
        foreach ($pm_sin_vincular as $pm) {
            $data['proceso_id'] = $pm->id;
            ProcesoModular::create($data);
            $inicio += 1;
        }

    }

    public function obtenerProcesosModularesNoVinculados($materia)
    {
        $procesos = Proceso::select('procesos.id')
            ->where('materia_id', '=', $materia)
            ->get();

        return Proceso::select('procesos.id')
            ->where('procesos.materia_id', $materia)
            ->whereNotIn(
                'procesos.id',
                ProcesoModular::select('proceso_modular.proceso_id')
                    ->whereIn('proceso_modular.proceso_id', $procesos)
            )
            ->get();
    }

    public function obtenerProcesosModularesByMateria($materia)
    {
        return ProcesoModular::select('proceso_modular.*')
            ->join('procesos','procesos.id', 'proceso_modular.proceso_id')
            ->where('procesos.materia_id', $materia)
            ->get();
    }

    public function ponderarCargos(Materia $materia)
    {
        $cargos = $materia->cargos()->get();
        foreach ($cargos as $cargo){
            /** @var Cargo $cargo */
            $cargo->calificacionesTPByCargoByMateria($materia->id);
        }


        return $materia->cargos()->get();
    }


}