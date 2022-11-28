<?php

namespace App\Services;

use App\Models\Calificacion;
use App\Models\ProcesoCalificacion;
use App\Models\TipoCalificacion;

class CalificacionService
{
 public const TIPO_PARCIAL = 1;
 public const TIPO_TP = 2;
 public const TIPO_TFI = 3;

    public function calificacionesByAlumno($alumno_id, $calificacion_id)
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->join('procesos', 'procesos.id', 'proceso_calificacion.proceso_id')
            ->where('proceso_calificacion.calificacion_id', $calificacion_id)
            ->where('procesos.alumno_id', $alumno_id)
            ->get();
    }

    public function calificacionesByProceso($proceso_id, $calificacion_id)
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->where('proceso_calificacion.calificacion_id', $calificacion_id)
            ->where('proceso_calificacion.proceso_id', $proceso_id)
            ->get();
    }

    public function calificacionParcialByAlumno($alumno_id, $calificacion_id)
    {
        $proceso_calificacion = $this->calificacionesByAlumno($alumno_id, $calificacion_id);
//        dd($proceso_calificacion);

        $pp = $pr = 0;
        if (isset($proceso_calificacion)) {
            $pp = $proceso_calificacion[0]->porcentaje ?? 0;
            $pr = $proceso_calificacion[0]->porcentaje_recuperatorio ?? 0;
        }

        return max($pp, $pr);
    }

    public function calificacionParcialByProceso($proceso_id, $calificacion_id)
    {
        $proceso_calificacion = $this->calificacionesByProceso($proceso_id, $calificacion_id);

        $pp = $pr = 0;
        if (isset($proceso_calificacion)) {
            $pp = $proceso_calificacion[0]->porcentaje ?? 0;
            if ($pp == -1) {
                $pp = 0;
            }
            $pr = $proceso_calificacion[0]->porcentaje_recuperatorio ?? 0;
        }

        return max($pp, $pr);
    }

    public function calificacionAusenteParcialByProceso($proceso_id, $calificacion_id)
    {
        $proceso_calificacion = $this->calificacionesByProceso($proceso_id, $calificacion_id);

        $ausente = 'P';
        if (isset($proceso_calificacion)) {
            $pp = $proceso_calificacion[0]->porcentaje ?? 0;
            if ($pp == -1) {
                $pp = 'A';
            }
            $pr = $proceso_calificacion[0]->porcentaje_recuperatorio ?? 'A';
        }
        if ($pp == 'A' or $pr == 'A') {
            $ausente = 'A';
        }

        return ($ausente);
    }

    public function calcularPorcentaje($proceso_id)
    {
        $calificaciones = ProcesoCalificacion::where([
            'proceso_id' => $proceso_id,
        ])->whereHas('calificacion', function ($query) {
            return $query->where('tipo_id', 2);
        })
            ->get();

        $array_calificaciones = [];

        foreach ($calificaciones as $calificacion) {
            if ($calificacion->nota == -1) {
                array_push($array_calificaciones, 0);
            } else {
                array_push($array_calificaciones, $calificacion->nota);
            }
        }

        $valorInicial = 0; // Valor inicial de array_reduce
        $suma = array_reduce($array_calificaciones, function ($acarreo, $numero) {
            return $acarreo + $numero;
        }, $valorInicial);

        // Obtener longitud
        $cantidadDeElementos = count($array_calificaciones);

        // Dividir, y listo
        $promedio = $suma / $cantidadDeElementos;

        return $promedio;
    }


    //// Calificaciones por materia
    public function calificacionesByMateria($materia_id)
    {
        return Calificacion::where([
            'materia_id' => $materia_id,
        ])
            ->get();
    }

    public function cuentaCalificacionesByMateria($materia_id): int
    {
        return count($this->calificacionesByMateria($materia_id));
    }

    //// Calificaciones por cargo
    public function calificacionesByCargo($cargo_id)
    {
        return Calificacion::where([
            'cargo_id' => $cargo_id,
        ])
            ->get();
    }

    public function cuentaCalificacionesByCargo($cargo_id): int
    {
        return count($this->calificacionesByCargo($cargo_id));
    }

    //// Calificaciones por materia y cargo

    public function calificacionesByMateriaCargo($materia_id, $cargo_id)
    {
        return Calificacion::where([
            'materia_id' => $materia_id,
            'cargo_id' => $cargo_id,
        ])
            ->get();
    }

    public function cuentaCalificacionesByMateriaCargo($materia_id, $cargo_id): int
    {
        return count($this->calificacionesByMateriaCargo($materia_id, $cargo_id));
    }

    //// Calificaciones por materia, cargo y tipo

    public function calificacionesByMateriaCargoTipo($materia_id, $cargo_id, $tipo_id)
    {
        return Calificacion::select('calificaciones.*')
            ->join('tipo_calificaciones', 'tipo_calificaciones.id', 'calificaciones.tipo_id')
            ->where('calificaciones.materia_id', $materia_id)
            ->where('calificaciones.cargo_id', $cargo_id)
            ->where('tipo_calificaciones.descripcion', $tipo_id)
            ->get();
    }

    public function cuentaCalificacionesByMateriaCargoTipo($materia_id, $cargo_id, $tipo_id): int
    {
        return count($this->calificacionesByMateriaCargoTipo($materia_id, $cargo_id, $tipo_id));
    }

}