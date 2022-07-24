<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Materia;
use App\Models\User;

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

    public function calculoPonderacionPorCargo(Cargo $cargo, int $materia_id, int $alumno_id)
    {
        $tp = $this->calculoPorcentajeCargoByTP($cargo, $materia_id, $alumno_id) * 0.7;
        $parc = $this->calculoPorcentajeCargoByParcial($cargo, $materia_id, $alumno_id) * 0.3;

        return $parc + $tp;

    }

}
