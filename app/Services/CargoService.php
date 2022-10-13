<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\CargoMateria;

class CargoService
{
    public function buscador($busqueda, $paginate = false)
    {
        $cargos = Cargo::select('cargos.*');

        if ($busqueda['nombre'] && $busqueda['nombre'] != '') {
            $cargos = $cargos->where('nombre', 'LIKE', '%'.$busqueda['nombre'].'%');
        }

        if ($busqueda['carrera_id'] && $busqueda['carrera_id'] != 'todos') {
            $cargos->where('carrera_id', $busqueda['carrera_id']);
        }

        if ($paginate) {
            return $cargos->paginate(30);
        } else {
            return $cargos->get();
        }
    }

    public function buscadorCargo($busqueda)
    {
        return Cargo::select('id', 'nombre')->where('nombre', $busqueda)->get();
    }

    /**
     * Obtiene el valor <b>porcentual</b> de la <i>ponderación</i> con respecto a la <i>materia</i>
     * @param $cargo
     * @param $materia
     * @return mixed
     */
    public function getPonderacion($cargo, $materia)
    {
        $ponderacion = 0;
        $cargo_materia = CargoMateria::where([
            'cargo_id' => $cargo,
            'materia_id' => $materia,
        ])->first();
        if ($cargo_materia) {
            $ponderacion = $cargo_materia->ponderacion;
        }

        return $ponderacion;
    }

    /**
     * Obtiene el valor <b>boolean</b> si es <i>responsable de TFI</i> con respecto al  <i>módulo</i>
     * @param $cargo
     * @param $materia
     * @return mixed
     */
    public function getResponsableTFI($cargo, $materia)
    {
        $responsable_tfi = false;
        $cargo_materia = CargoMateria::where([
            'cargo_id' => $cargo,
            'materia_id' => $materia,
        ])->first();
        if ($cargo_materia) {
            $responsable_tfi = $cargo_materia->carga_tfi;
        }

        return $responsable_tfi;
    }

    /**
     * Obtiene el modelo  <b>cargo-modulo</b>
     * @param $cargo
     * @param $materia
     * @return mixed
     */
    public function getRelacionCargoModulo($cargo, $materia)
    {

        return CargoMateria::where([
            'cargo_id' => $cargo,
            'materia_id' => $materia,
        ])->first();
    }

    public function calculoPorcentajeCargoByTPGeneral(Cargo $cargo, int $materia_id)
    {
        $cant = count($cargo->calificacionesTPByCargoByMateria($materia_id));
        $suma = 0;
        $percent = 0;
        foreach ($cargo->calificacionesTPByCargoByMateria($materia_id) as $calificacion) {

            if (count($calificacion->procesosCalificacionByAlumno($alumno_id)) > 0) {
                $suma += $calificacion->procesosCalificacionByAlumno($alumno_id)[0]->porcentaje;
            }
        }
        if ($cant > 0) {
            $percent = $suma / $cant;
        }

        return $percent;
    }

    public function calculoPorcentajeCargoByTPPorAlumno(Cargo $cargo, int $materia_id, int $alumno_id)
    {
        $cant = count($cargo->calificacionesTPByCargoByMateria($materia_id));
        $suma = 0;
        $percent = 0;
        foreach ($cargo->calificacionesTPByCargoByMateria($materia_id) as $calificacion) {
            if (count($calificacion->procesosCalificacionByAlumno($alumno_id)) > 0) {
                $suma += $calificacion->procesosCalificacionByAlumno($alumno_id)[0]->porcentaje;
            }
        }
        if ($cant > 0) {
            $percent = $suma / $cant;
        }

        return $percent;
    }

    public function calculoPorcentajeCargoByTPPorProceso(Cargo $cargo, int $materia_id, int $proceso_id)
    {
        $cant = count($cargo->calificacionesTPByCargoByMateria($materia_id));
        $suma = 0;
        $percent = 0;
        foreach ($cargo->calificacionesTPByCargoByMateria($materia_id) as $calificacion) {
            if (count($calificacion->procesosCalificacionByProceso($proceso_id)) > 0) {
                $sumaCalificacion = 0;
                if($calificacion->procesosCalificacionByProceso($proceso_id)[0]->porcentaje > 0){
                    $sumaCalificacion = $calificacion->procesosCalificacionByProceso($proceso_id)[0]->porcentaje;
                }
                $suma += $sumaCalificacion;
            }
        }
        if ($cant > 0) {
            $percent = $suma / $cant;
        }

        return $percent;
    }

    public function calculoPorcentajeCargoByParcial(Cargo $cargo, int $materia_id, int $alumno_id)
    {
        $cant = count($cargo->calificacionesParcialByCargoByMateria($materia_id));
        $suma = 0;
        $percent = 0;
        foreach ($cargo->calificacionesParcialByCargoByMateria($materia_id) as $calificacion) {
            if (count($calificacion->procesosCalificacionByAlumno($alumno_id)) > 0) {
                $suma += $calificacion->procesosCalificacionByAlumno($alumno_id)[0]->porcentaje;
            }
        }
        if ($cant > 0) {
            $percent = $suma / $cant;
        }

        return $percent;
    }


    public function calculoPorcentajeCargoByParcialAndProceso(Cargo $cargo, int $materia_id, int $proceso_id)
    {
        $cant = count($cargo->calificacionesParcialByCargoByMateria($materia_id));
        $suma = 0;
        $percent = 0;
        foreach ($cargo->calificacionesParcialByCargoByMateria($materia_id) as $calificacion) {
            if (count($calificacion->procesosCalificacionByProceso($proceso_id)) > 0) {
                $suma += $calificacion->procesosCalificacionByProceso($proceso_id)[0]->porcentaje;
            }
        }
        if ($cant > 0) {
            $percent = $suma / $cant;
        }

        return $percent;
    }

    public function calculoPorcentajeCalificacionPorCargo(Cargo $cargo, int $materia_id, int $alumno_id): float
    {
        $tp = $this->calculoPorcentajeCargoByTPPorAlumno($cargo, $materia_id, $alumno_id) * 0.7;
        $parc = $this->calculoPorcentajeCargoByParcial($cargo, $materia_id, $alumno_id) * 0.3;
        return $parc + $tp;
    }

    public function calculoPorcentajeCalificacionPorCargoAndProceso(Cargo $cargo, int $materia_id, int $proceso_id): float
    {
        $tp = $this->calculoPorcentajeCargoByTPPorProceso($cargo, $materia_id, $proceso_id) * 0.7;
        $parc = $this->calculoPorcentajeCargoByParcialAndProceso($cargo, $materia_id, $proceso_id) * 0.3;
        return $parc + $tp;
    }



    public function calculoPorcentajeTFIPorCargo(Cargo $cargo, int $materia_id, int $alumno_id): float
    {
        $tp = $this->calculoPorcentajeCargoByTPPorAlumno($cargo, $materia_id, $alumno_id) * 0.7;
        $parc = $this->calculoPorcentajeCargoByParcial($cargo, $materia_id, $alumno_id) * 0.3;
        return $parc + $tp;
    }

    public function obtenerPorcentajeCalificacionPracticaProfesional(Cargo $cargo, int $materia_id, int $alumno_id): ?float
    {
        return null;
    }

}
