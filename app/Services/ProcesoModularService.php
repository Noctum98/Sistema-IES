<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Materia;
use App\Models\Proceso;
use App\Models\ProcesoModular;


class ProcesoModularService
{

    /**
     * @param $materia_id <b>id</b> materia
     * @return void
     */
    public function crearProcesoModular(int $materia_id)
    {
        $pm_sin_vincular = $this->obtenerProcesosModularesNoVinculados($materia_id);
        $inicio = 0;
        foreach ($pm_sin_vincular as $pm) {
            $data['proceso_id'] = $pm->id;
            ProcesoModular::create($data);
            $inicio += 1;
        }

    }

    /**
     * @param int $materia_id <b>id</b> materia
     * @return mixed
     */
    public function obtenerProcesosModularesNoVinculados(int $materia_id)
    {
        $procesos = Proceso::select('procesos.id')
            ->where('materia_id', '=', $materia_id)
            ->get();

        return Proceso::select('procesos.id')
            ->where('procesos.materia_id', $materia_id)
            ->whereNotIn(
                'procesos.id',
                ProcesoModular::select('proceso_modular.proceso_id')
                    ->whereIn('proceso_modular.proceso_id', $procesos)
            )
            ->get();
    }

    /**
     * @param $materia_id <b>id</b> de la materia
     * @return mixed
     */
    public function obtenerProcesosModularesByMateria($materia_id)
    {
        return ProcesoModular::select('proceso_modular.*')
            ->join('procesos', 'procesos.id', 'proceso_modular.proceso_id')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->orderBy('alumnos.apellidos', 'asc')
            ->get();
    }

    public function ponderarCargos(Materia $materia)
    {
        $cargos = $materia->cargos()->get();
        foreach ($cargos as $cargo) {
            /** @var Cargo $cargo */
            $cargo->calificacionesTPByCargoByMateria($materia->id);
        }

        return $materia->cargos()->get();
    }

    public function cargarPonderacionEnProcesoModular(Materia $materia)
    {
        $this->crearProcesoModular($materia->id);

        $serviceCargo = new CargoService();
        $serviceProcesoCalificacion = new ProcesoCalificacionService();
        $cant = 0;
        $cargos = $this->obtenerCargosPorModulo($materia);
        $promedio_final_p = 0;
        $procesos = $this->obtenerProcesosModularesByMateria($materia->id);
        foreach ($procesos as $proceso) {
            $promedio_final_p = 0;
            foreach ($cargos as $cargo) {
                /** @var ProcesoModular $proceso */
                $ponderacion_cargo_materia = CargoMateria::where([
                    'cargo_id' => $cargo->id,
                    'materia_id' => $materia->id,
                ])->first();
                $porcentaje_cargo = $serviceCargo->calculoPonderacionPorCargo(
                        $cargo,
                        $materia->id,
                        $proceso->alumnoRelacionado()->id
                    ) ?? 0;
                $ponderacion_asignada = $ponderacion_cargo_materia->ponderacion ?? 0;
                $promedio_final_p += $porcentaje_cargo * $ponderacion_asignada / 100;
            }
            $proceso->promedio_final_porcentaje = $promedio_final_p;
            $proceso->promedio_final_nota = $nota = $serviceProcesoCalificacion->calculoPorcentajeNota($promedio_final_p);

            $proceso->update();

            $cant += 1;

        }

        return $cant;

    }

    public function obtenerCargosPorModulo(Materia $modulo)
    {
        return $modulo->cargos()->get();
    }

    public function obtenerUltimaCalificacion($materia)
    {
        return ProcesoModular::select('proceso_modular.*')
            ->join('procesos', 'procesos.id', 'proceso_modular.proceso_id')
            ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
            ->where('procesos.materia_id', $materia_id)
            ->orderBy('alumnos.apellidos', 'asc')
            ->get();
    }


}