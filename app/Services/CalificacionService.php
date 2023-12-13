<?php

namespace App\Services;

use App\Models\Calificacion;
use App\Models\ProcesoCalificacion;
use App\Models\TipoCalificacion;
use Illuminate\Support\Collection;
use LaravelIdea\Helper\App\Models\_IH_ProcesoCalificacion_C;

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

    /**
     * @param $proceso_id
     * @param $calificacion_id
     * @return mixed
     */
    public function calificacionesByProceso($proceso_id, $calificacion_id)
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->where('proceso_calificacion.calificacion_id', $calificacion_id)
            ->where('proceso_calificacion.proceso_id', $proceso_id)
            ->get();
    }

    /**
     * Obtener la calificación del proceso por ID de proceso y el ID de calificación
     *
     * @param int $proceso_id proceso ID
     * @param int $calificacion_id calificacion ID
     * @return ProcesoCalificacion|null ProcesoCalificacion object o null si no encuentra
     */
    public function getCalificacionByProceso(int $proceso_id, int $calificacion_id): ProcesoCalificacion
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->where('proceso_calificacion.calificacion_id', $calificacion_id)
            ->where('proceso_calificacion.proceso_id', $proceso_id)
            ->first();
    }


    /**
     * Retorna un array con las calificaciones de un proceso específico
     *
     * @param int $proceso_id El ID del proceso
     * @param mixed $calificacion_id El ID o IDs de las calificaciones (array o string)
     * @return ProcesoCalificacion[] Array de objetos ProcesoCalificacion
     */
    public function calificacionesArrayByProceso(int $proceso_id, $calificacion_id)
    {
        return ProcesoCalificacion::select('proceso_calificacion.*')
            ->where('proceso_calificacion.proceso_id', $proceso_id)
            ->whereIn('proceso_calificacion.calificacion_id', $calificacion_id)
            ->get();
    }

    public function calificacionParcialByAlumno($alumno_id, $calificacion_id)
    {
        $proceso_calificacion = $this->calificacionesByAlumno($alumno_id, $calificacion_id);

        $pp = $pr = 0;
        if (isset($proceso_calificacion)) {
            $pp = $proceso_calificacion[0]->porcentaje ?? 0;
            $pr = $proceso_calificacion[0]->porcentaje_recuperatorio ?? 0;
        }

        return max($pp, $pr);
    }


    /**
     * @param $alumno_id <b>id</b> del alumno
     * @param $calificacion_id <i>La calificación</i> a procesar
     * @return mixed La nota máxima del parcial o el recuperatorio
     */
    public function notaCalificacionParcialByAlumno($alumno_id, $calificacion_id)
    {
        $proceso_calificacion = $this->calificacionesByAlumno($alumno_id, $calificacion_id);

        $pp = $pr = 0;
        if (isset($proceso_calificacion)) {
            $pp = $proceso_calificacion[0]->nota ?? 0;
            $pr = $proceso_calificacion[0]->nota_recuperatorio ?? 0;
        }

        return max($pp, $pr);
    }

    /**
     * Procesa las calificaciones desde el proceso.
     *
     * @param $proceso_id
     * @param $calificacion_id
     * @return mixed La nota máxima del parcial o el recuperatorio
     */
    public function calificacionParcialByProceso($proceso_id, $calificacion_id)
    {
        $proceso_calificacion = $this->calificacionesByProceso($proceso_id, $calificacion_id);

        $pp = $pr = 0;
        if (isset($proceso_calificacion)) {
            $pp = $proceso_calificacion[0]->nota ?? 0;
            if ($pp == -1) {
                $pp = 0;
            }
            $pr = $proceso_calificacion[0]->nota_recuperatorio ?? 0;
        }

        return max($pp, $pr);
    }


    /**
     * Obtiene la calificación para el Trabajo Práctico (TP) especificado por el proceso.
     *
     * @param int $proceso_id El ID del proceso por el cual buscamos la calificación.
     * @param int $calificacion_id El ID de la calificación que estamos buscando.
     * @return float La calificación obtenida por el TP para el proceso especificado.
     * Retornará 0 en caso de que la calificación no haya sido establecida (valor -1)
     * o el proceso no exista.
     */
    public function calificacionTpByProceso(int $proceso_id, int $calificacion_id):float
    {
        $proceso_calificacion = $this->calificacionesByProceso($proceso_id, $calificacion_id);

        $ptp  = 0;
        if (isset($proceso_calificacion)) {
            $ptp = $proceso_calificacion[0]->nota ?? 0;
            if ($ptp == -1) {
                $ptp = 0;
            }
        }

        return $ptp;
    }


    /**
     * @param $proceso_id
     * @param $calificacion_id
     * @return string
     */
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

    /**
     * Cambia un '-1' en 'A'
     *
     * @param $proceso_id
     * @param $calificacion_id
     * @return string
     */
    public function notaCalificacionAusenteParcialByProceso($proceso_id, $calificacion_id): string
    {
        $proceso_calificacion = $this->calificacionesByProceso($proceso_id, $calificacion_id);

        $ausente = 'P';
        if (isset($proceso_calificacion)) {
            $pp = $proceso_calificacion[0]->nota ?? 0;
            if ($pp == -1) {
                $pp = 'A';
            }
            $pr = $proceso_calificacion[0]->nota_recuperatorio ?? 'A';
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

    /**
     * @param $cargo_id
     * @param $ciclo_lectivo
     * @return mixed
     */
    public function calificacionesByCargo($cargo_id, $ciclo_lectivo)
    {
        return Calificacion::where([
            'cargo_id' => $cargo_id,
            'ciclo_lectivo' => $ciclo_lectivo
        ])
            ->get();
    }

    /**
     * Retorna las calificaciones que corresponden a ciertos cargos en un ciclo lectivo y materia determinados.
     *
     * @param array $cargos Los cargos para los cuales se desea obtener las calificaciones.
     * @param int $ciclo_lectivo El ciclo lectivo del cual se desean obtener las calificaciones.
     * @param array $tipos Los tipos de calificaciones que se desean obtener.
     * @param int $materia El ID de la materia de la cual se desean obtener las calificaciones.
     * @return Collection Una colección que contiene las calificaciones correspondientes.
     */
    public function calificacionesInCargos(array $cargos , int $ciclo_lectivo, array $tipos, int $materia): Collection
    {
        return Calificacion::select('calificaciones.*')
            ->join('tipo_calificaciones','calificaciones.tipo_id','tipo_calificaciones.id')
            ->where('ciclo_lectivo', '=', $ciclo_lectivo)
            ->where('materia_id', '=', $materia)
            ->whereIn('cargo_id', $cargos)
            ->whereIn('tipo_calificaciones.descripcion', $tipos)
            ->get()
            ;
    }

    public function cuentaCalificacionesByCargo($cargo_id, $ciclo_lectivo): int
    {
        return count($this->calificacionesByCargo($cargo_id, $ciclo_lectivo));
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

    /**
     * Obtengo una calificación específica
     *
     * @param $materia_id
     * @param $cargo_id
     * @param $tipo_id
     * @param $ciclo_lectivo
     * @return mixed
     */
    public function calificacionesByMateriaCargoTipo($materia_id, $cargo_id, $tipo_id, $ciclo_lectivo)
    {
        return Calificacion::select('calificaciones.*')
            ->join('tipo_calificaciones', 'tipo_calificaciones.id', 'calificaciones.tipo_id')
            ->where('calificaciones.materia_id', $materia_id)
            ->where('calificaciones.cargo_id', $cargo_id)
            ->where('calificaciones.ciclo_lectivo', $ciclo_lectivo)
            ->where('tipo_calificaciones.descripcion', $tipo_id)
            ->get();
    }

    public function cuentaCalificacionesByMateriaCargoTipo($materia_id, $cargo_id, $tipo_id, $ciclo_lectivo): int
    {
        return count($this->calificacionesByMateriaCargoTipo($materia_id, $cargo_id, $tipo_id, $ciclo_lectivo));
    }

}
