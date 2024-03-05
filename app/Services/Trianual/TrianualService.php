<?php

namespace App\Services\Trianual;

use App\Models\Trianual\Trianual;
use App\Models\AlumnoCarrera;

/**
 * Class TrianualService
 *
 * Clase de servicio para operaciones en el modelo Trianual
 */
class TrianualService
{
    /**
     * @var Trianual
     */
    protected Trianual $trianualModel;

    /**
     * TrianualService constructor.
     *
     * @param Trianual $trianual
     */
    public function __construct(Trianual $trianual)
    {
        $this->trianualModel = $trianual;
    }

    /**
     * Obtiene los alumnos de una carrera específica
     *
     * @param int $carrera_id El `id` de la carrera
     * @param int $year El año de la carrera (1°, 2°, 3°)
     * @param int|null $ciclo_lectivo El ciclo lectivo
     * @return array Array de alumnos
     */
    public function getAlumnosDeCarreraYearCicloLectivo(int $carrera_id, int $year, int $ciclo_lectivo = null): array
    {
        if (!$ciclo_lectivo) {
            $ciclo_lectivo = date('Y');
        }

        $alumnosCarrera = AlumnoCarrera::where([
            ['alumno_carrera.carrera_id', '=', $carrera_id],
            ['alumno_carrera.año', '=', $year],
            ['alumno_carrera.ciclo_lectivo', '=', $ciclo_lectivo]
        ])
            ->join('alumnos', 'alumnos.id', '=', 'alumno_carrera.alumno_id')
            ->orderBy('alumnos.apellidos')
            ->get();

        $alumnos = [];

        foreach ($alumnosCarrera as $alumnoCarrera) {

            if ($alumnoCarrera->alumno()->first()) {
                $alumnos[] = $alumnoCarrera->alumno()->first();
            }
        }


        return $alumnos;
    }
}
