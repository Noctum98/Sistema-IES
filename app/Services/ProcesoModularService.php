<?php

namespace App\Services;

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
                $porcentaje_cargo = $serviceCargo->calculoPorcentajeCalificacionPorCargo(
                    $cargo,
                    $materia->id,
                    $proceso->alumnoRelacionado()->id
                ) ?? 0;
                $ponderacion_asignada = $ponderacion_cargo_materia->ponderacion ?? 0;
                $promedio_final_p += $porcentaje_cargo * $ponderacion_asignada / 100;
            }
            $proceso->promedio_final_porcentaje = $promedio_final_p;
            $proceso->promedio_final_nota = $nota = $serviceProcesoCalificacion->calculoPorcentajeNota(
                $promedio_final_p
            );

            $proceso->update();

            $cant += 1;

        }

        return $cant;

    }

    public function obtenerCargosPorModulo(Materia $modulo)
    {
        return $modulo->cargos()->get();
    }

    public function obtenerTimeUltimaCalificacion($materia_id)
    {
        $serviceProcesoCalificacion = new ProcesoCalificacionService();

        return $serviceProcesoCalificacion->obtenerTimeUltimaCalificacionPorModulo($materia_id);
    }

    public function obtenerTimeUltimoProcesoModular($materia_id)
    {
        return ProcesoModular::select('proceso_modular.updated_at')
            ->join('procesos', 'procesos.id', 'proceso_modular.proceso_id')
            ->where('procesos.materia_id', $materia_id)
            ->orderBy('proceso_modular.updated_at', 'desc')
            ->first();
    }

    public function obtenerEstadoAlumnoEnModulo($materia_id)
    {
        /**
         * Mirando👆 Módulos sería Acreditación Directa si Asist >75%, Proceso >60%, Promedio >78% y TFI >78%
         * Regular si Asist entre 60 y 75% y PP 100%, Promedio entre 60 y 78, TFI entre 60 y 78
         */

        $procesosModulares = $this->obtenerProcesosModularesByMateria($materia_id);

        foreach ($procesosModulares as $pm) {
            /** @var ProcesoModular $pm */
//            print_r($pm->proceso_id->alumno_id);
            if($this->getAsistenciaModularBoolean(75, $pm->procesoRelacionado()->first()) === false){
                return $this->getAsistenciaModularBoolean(75, $pm->procesoRelacionado()->first() , 60);
            }
            return true;
        }


//        $asistencia = $procesoModular->asistencia_final_porcentaje;
//        $proceso = $procesoModular->promedio_final_porcentaje;


    }

    public function regularityDirectAccreditation(Proceso $proceso)
    {
        $this->getAsistenciaModularBoolean(75, $proceso);
    }


    public function getAsistenciaModularBoolean(
        int $porcentaje_max,
        Proceso $proceso,
        int $porcentaje_min = null
    ) {
        $cargos = $proceso->materia()->first()->cargos()->get();

        foreach ($cargos as $cargo) {

            if ($proceso->asistencia() and $proceso->asistencia()->getByAsistenciaCargo($cargo->id)) {

                if ($porcentaje_min) {

                    if ($proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje
                        < $porcentaje_min) {
                        return false;
                    }

                } else {
                    if ($proceso->asistencia()->getByAsistenciaCargo($cargo->id)->porcentaje
                        < $porcentaje_max) {


                        return false;
                    }
                }
            } else {
                return false;
            }
        }

        return true;
    }

    public function getCalificacionModularBoolean(
        int $porcentaje_max,
        Proceso $proceso
    ): bool
    {
        $serviceCargo = new CargoService();
        $materia_id = $proceso->materia()->first()->id;
        $alumno_id = $proceso->alumno()->first()->id;
        $cargos = $proceso->materia()->first()->cargos()->get();
        foreach ($cargos as $cargo) {
            $serviceCargo->calculoPorcentajeCalificacionPorCargo($cargo, $materia_id, $alumno_id);
            }


    }


}