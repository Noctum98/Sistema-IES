<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\CargoMateria;
use App\Models\Configuration;

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
        $cant = $this->getCantTpByCargoMateria($cargo, $materia_id);
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
        $cant = $this->getCantTpByCargoMateria($cargo, $materia_id);
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
        $cant = $this->getCantTpByCargoMateria($cargo, $materia_id);
        $suma = 0;
        $percent = 0;
        foreach ($cargo->calificacionesTPByCargoByMateria($materia_id) as $calificacion) {
            if (count($calificacion->procesosCalificacionByProceso($proceso_id)) > 0) {
                $sumaCalificacion = 0;
                if ($calificacion->procesosCalificacionByProceso($proceso_id)[0]->porcentaje > 0) {
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
        $valueParcial = Configuration::select('value_parcial')->first();
        $resultado = 0;
        if ($valueParcial->value_parcial) {
            $tp = $this->calculoPorcentajeCargoByTPPorAlumno(
                    $cargo,
                    $materia_id,
                    $alumno_id
                ) * (1 - $valueParcial->value_parcial / 100);
            $parc = $this->calculoPorcentajeCargoByParcial(
                    $cargo,
                    $materia_id,
                    $alumno_id
                ) * ($valueParcial->value_parcial / 100);
            $resultado = $parc + $tp;
        } else {
            $cantTp = $this->getCantTpByCargoMateria($cargo, $materia_id);
            $total = $this->calculoPorcentajeCargoByTPPorAlumno($cargo, $materia_id, $alumno_id);
            $parcial = $this->calculoPorcentajeCargoByParcial($cargo, $materia_id, $alumno_id);
            if (is_numeric($parcial)) {
                $totalTp = $total * $cantTp;
                $total = ($totalTp + $parcial) / ($cantTp + 1);
            }
            $resultado = $total;
        }

        return $resultado;
    }


    /**
     * @param $cantidad_tp
     * @param $suma_tp
     * @param $cantidad_p
     * @param $suma_p
     * @return float
     */
    public function calculoPorcentajeCalificacionFromBlade($cantidad_tp, $suma_tp, $cantidad_p, $suma_p): float
    {
        $valueParcial = Configuration::select('value_parcial')->first();
        $resultado = 0;
        /** El factorDivision en 2 por trabajos prácticos y parciales */
        $practicalJobs = 0;
        $parciales = 0;
        $factorDivision = 2;
        if (!$cantidad_tp or !$cantidad_p) {
            $factorDivision = 1;
        }


        /** Pongo el valor de los parciales  a null  */
        $parciales = null;
        /** Pongo el valor de los trabajos prácticos a null  */
        $practicalJobs = null;

        /**
         * Pregunto si hay proporcionalidad entre parciales y trabajos prácticos
         */

        if ($valueParcial->value_parcial) {
            /** Caso Positivo de ponderación de parciales */

            /** Consulto si hay trabajos prácticos y obtengo su valor*/
            if ($cantidad_tp > 0) {
                /** Obtengo el % de trabajos prácticos */
                // Sin parciales
                $percentPracticalHobs = 1;
                // Con parciales
                if ($cantidad_p > 0) {
                    $percentPracticalHobs = 1 - $valueParcial->value_parcial / 100;
                }

                /** Obtengo el valor de los trabajos prácticos */
                $practicalJobs = ($suma_tp / $cantidad_tp) * $percentPracticalHobs;
            }

            /** Consulto si hay parciales y obtengo su valor */
            if ($cantidad_tp) {
                /** Obtengo % de parciales sin trabajos prácticos */
                $percentPartial = 1;
                if ($cantidad_tp > 0) {
                    /** Obtengo % de parciales con trabajos prácticos */
                    $percentPartial = $valueParcial->value_parcial / 100;
                }
                /** Obtengo el valor de los parciales */
                $parciales = ($suma_p / $cantidad_p) * $percentPartial;
            }

            $resultado = $practicalJobs + $parciales;
        } else {
            /** Caso Negativo de ponderación de parciales */
            $suma_total = 0;
            $cantidad_total = 0;
            /** Consulto si hay trabajos prácticos y obtengo su valor*/
            if ($cantidad_tp > 0) {
                $cantidad_total += $cantidad_tp;
                $suma_total += $suma_tp;
            }

            if ($cantidad_p > 0) {
                $cantidad_total += $cantidad_p;
                $suma_total += $suma_p;
            }

            if($cantidad_total > 0) {
                $resultado = $suma_total / $cantidad_total;
            }

        }


        return $resultado;
    }

    /**
     * ProcesoModularService.php:157
     * @param Cargo $cargo
     * @param int $materia_id
     * @param int $proceso_id
     * @return float
     */
    public function calculoPorcentajeCalificacionPorCargoAndProceso(
        Cargo $cargo, int $materia_id, int $proceso_id): float
    {
        $calcPTP = $this->calculoPorcentajeCargoByTPPorProceso(
            $cargo, $materia_id, $proceso_id
        ) < 0 ? 0 : $this->calculoPorcentajeCargoByTPPorProceso($cargo, $materia_id, $proceso_id);
        $tp = $calcPTP * 0.7;
        $calcPP = $this->calculoPorcentajeCargoByParcialAndProceso(
            $cargo,
            $materia_id,
            $proceso_id
        ) < 0 ? 0 : $this->calculoPorcentajeCargoByParcialAndProceso($cargo, $materia_id, $proceso_id);
        $parc = $calcPP * 0.3;

        return $parc + $tp;
    }

    public function calculoPorcentajeTFIPorCargo(Cargo $cargo, int $materia_id, int $alumno_id): float
    {
        $tp = $this->calculoPorcentajeCargoByTPPorAlumno($cargo, $materia_id, $alumno_id) * 0.7;
        $parc = $this->calculoPorcentajeCargoByParcial($cargo, $materia_id, $alumno_id) * 0.3;

        return $parc + $tp;
    }

    public function obtenerPorcentajeCalificacionPracticaProfesional(
        Cargo $cargo,
        int $materia_id,
        int $alumno_id
    ): ?float {
        return null;
    }

    /**
     * @param Cargo $cargo
     * @param int $materia_id
     * @return int
     */
    protected function getCantTpByCargoMateria(Cargo $cargo, int $materia_id): int
    {
        return count($cargo->calificacionesTPByCargoByMateria($materia_id));
    }

}
