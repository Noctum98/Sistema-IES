<?php

namespace App\Console\Commands;

use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AjustesInscripciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AjustesInscripciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $alumnos = Alumno::all();

        foreach ($alumnos as $alumno) {
            foreach ($alumno->procesos_actuales as $proceso) {
                $carrera = $proceso->materia->carrera;
                $alumno_carrera = AlumnoCarrera::where([
                    'alumno_id' => $alumno->id,
                    'carrera_id' => $carrera->id,
                    'ciclo_lectivo' => date('Y')
                ])->first();

                if (!$alumno_carrera) {
                    $alumno_carrera = AlumnoCarrera::create([
                        'alumno_id' => $alumno->id,
                        'carrera_id' => $carrera->id,
                        'año'   => $proceso->materia->año,
                        'ciclo_lectivo' => date('Y')
                    ]);

                    echo $alumno->nombres . ' ' . $alumno->apellidos . '(' . $alumno->dni . '): ' . $carrera->nombre . '(' . $carrera->turno . ') ' . $carrera->resolucion . ' | ';
                    // Log::info($alumno->nombres . ' ' . $alumno->apellidos . '(' . $alumno->dni . '): ' . $carrera->nombre . '(' . $carrera->turno . ') ' . $carrera->resolucion);
                }
            }
        }
    }
}
