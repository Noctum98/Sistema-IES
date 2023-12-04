<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Proceso;
use App\Models\ProcesoModular;
use Illuminate\Support\Facades\DB;

class ProcesoService
{
    public function inscribir($alumno_id, $materias)
    {
        $data = [];
        $data['alumno_id'] = $alumno_id;

        foreach ($materias as $materia) {
            $data['materia_id'] = $materia;
            $data['estado'] = 'en curso';
            $data['ciclo_lectivo'] = date('Y');
            Proceso::create($data);
        }
    }

    public function cierraProcesoDesdeModular(int $proceso)
    {
        $proceso = Proceso::find($proceso);
        if ($proceso) {
            /** @var ProcesoModular $procesoModular */
            $procesoModular = ProcesoModular::where([
                'proceso_id' => $proceso->id
            ])->first();
            if ($procesoModular) {
                /** @var Proceso $proceso */
                $proceso->cierre = 1;
                $proceso->final_calificaciones = $procesoModular->nota_final_nota;
                $proceso->porcentaje_final_calificaciones = $procesoModular->nota_final_porcentaje;
                $proceso->final_asistencia = $procesoModular->asistencia_final_porcentaje;
                $proceso->update();
            }
        }
    }

    public function verificarRepetido($procesoVerificar, $procesos)
    {
        $procesoRepetido = $procesos->where('alumno_id',$procesoVerificar->alumno_id)->where('id','!=',$procesoVerificar->id)->first();

        if($procesoRepetido)
        {
            if(!$procesoRepetido->final_trabajos && !$procesoRepetido->final_asistencia && $procesoVerificar->final_asistencia && $procesoVerificar->final_trabajos)
            {
                $procesoRepetido->delete();


                return true;
            }elseif($procesoRepetido->final_trabajos && $procesoRepetido->final_asistencia && !$procesoVerificar->final_asistencia && !$procesoVerificar->final_trabajos)
            {

                $procesoVerificar->delete();

                return true;

            }elseif($procesoRepetido->final_trabajos && $procesoRepetido->final_asistencia && $procesoVerificar->final_asistencia && $procesoVerificar->final_trabajos)
            {

                return false;
            }elseif(!$procesoRepetido->final_trabajos && !$procesoRepetido->final_asistencia && !$procesoVerificar->final_asistencia && !$procesoVerificar->final_trabajos && !$procesoRepetido->deleted_at && !$procesoVerificar->deleted_at)
            {

                $procesoRepetido->delete();

                return true;
            }

        }

        return true;
    }

    /**
     * @param int $alumno
     * @param int $materia
     * @return mixed
     */
    public function procesoPorAlumnoMateria(int $alumno, int $materia)
    {
        return Proceso::where([
            'alumno_id' => $alumno,
            'materia_id' => $materia,
        ])
            ->orderBy('ciclo_lectivo', 'DESC')
            ->first();
    }


}
