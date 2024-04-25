<?php

namespace App\Services\Mesas;

use App\Models\ActaVolante;
use App\Models\Materia;
use App\Models\MesaAlumno;
use App\Models\Nota;
use App\Models\Proceso;

class MesaAlumnoService
{

    public function obtenerInscripciones($instancia_id,$materia_id,$estado_baja)
    {
        $inscripciones = MesaAlumno::where([
            'instancia_id' => $instancia_id,
            'materia_id' => $materia_id,
            'estado_baja' => $estado_baja
        ])->get();

        return $inscripciones;
    }

    public function condicionesRendir($mesa_alumno_id,$materia_id)
    {
        $mesa_alumno = MesaAlumno::find($mesa_alumno_id);
        $materia = Materia::find($materia_id);

        $data['legajo_completo'] = 0;
        $data['correlativas_incompletas'] = [];
        $data['regularidad'] = 0;
        $inscripcionCarrera = $mesa_alumno->alumno->lastProcesoCarrera($materia->carrera_id);
        $regularidad_identificadores = [1,3,4,7];
        $procesoRegular = Proceso::where(['materia_id'=>$materia->id,'alumno_id',$mesa_alumno->alumno_id])->where('ciclo_lectivo','>=',$inscripcionCarrera->cohorte)->whereHas('estado',function($query) use ($regularidad_identificadores){
            return $query->whereIn('identificador',$regularidad_identificadores);
        })->first();


        if ($inscripcionCarrera->legajo_completo && $inscripcionCarrera->cohorte <= date('Y', strtotime($mesa_alumno->created_at))) {
            $data['legajo_completo'] = 1;
        }

        if($procesoRegular)
        {
            $data['regularidad'] = 1;
        }

        $mesa_fecha = $mesa_alumno->mesa ? date('Y', strtotime($mesa_alumno->mesa->fecha)) : date('Y', strtotime($mesa_alumno->created_at));
        $nota = Nota::select('valor')->where(['min'=>60,'year'=>$mesa_fecha])->first();
        $correlativas = $materia->correlativas();

        foreach($correlativas as $correlativa)
        {
            $acta_volante = ActaVolante::where(['alumno_id'=>$mesa_alumno->alumno_id,'materia_id'=>$correlativa->id])->where('promedio','>=',$nota->valor)
            ->whereHas('inscripcionCarrera',function($query) use ($mesa_fecha){
                return $query->where('cohorte','<=',$mesa_fecha);
            })->first();

            if(!$acta_volante)
            {
                array_push($data['correlativas_incompletas'],$correlativa); 
            }
        }
        
        return $data;
    }


}