<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Proceso;
use Illuminate\Support\Facades\Log;

class ComisionService
{

    protected $userService;

    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function hasProfesor($comision, $profesor_id)
    {
        if ($comision->profesores->where('id', $profesor_id)->first()) {
            return true;
        }
        return false;
    }

    public function storeUnicas($comision, $materias)
    {
        foreach ($materias as $materia) {

            $procesos = Proceso::where([
                'materia_id'=> $materia->id,
                'ciclo_lectivo' => $comision->ciclo_lectivo
            ])->get();

            $profesores = $materia->profesores;
            Log::info($materia->nombre);
            Log::info($profesores);

            foreach ($procesos as $proceso) {
                if(!$comision->hasProceso($proceso->id))
                {
                    $comision->procesos()->attach($proceso);
                }

                if(!$comision->hasAlumno($proceso->alumno_id))
                {
                    $comision->alumnos()->attach(Alumno::find($proceso->alumno_id));
                }
            }

            foreach ($profesores as $profesor) {
                if(!$comision->hasProfesor($profesor->id))
                {
                    $comision->profesores()->attach($profesor);
                }
            }
        }
    }
}
