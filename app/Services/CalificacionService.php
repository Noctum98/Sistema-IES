<?php

namespace App\Services;

use App\Models\ProcesoCalificacion;

class CalificacionService
{
    public function calificacionesByAlumno($alumno_id, $calificacion_id)
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->join('procesos', 'procesos.id', 'proceso_calificacion.proceso_id')
            ->where('proceso_calificacion.calificacion_id', $calificacion_id)
            ->where('procesos.alumno_id', $alumno_id)
            ->get();
    }

    public function calificacionParcialByAlumno($alumno_id, $calificacion_id)
    {
        $proceso_calificacion = $this->calificacionesByAlumno($alumno_id, $calificacion_id);
//        dd($proceso_calificacion);

        $pp = $pr = 0;
        if (isset($proceso_calificacion)) {
            $pp = $proceso_calificacion[0]->porcentaje??0;
            $pr = $proceso_calificacion[0]->porcentaje_recuperatorio??0;
        }

        return max($pp, $pr);
    }

    public function calcularPorcentaje($proceso_id)
    {
        $calificaciones = ProcesoCalificacion::where([
            'proceso_id' => $proceso_id,
        ])->whereHas('calificacion',function($query){
            return $query->where('tipo_id',2);
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

}