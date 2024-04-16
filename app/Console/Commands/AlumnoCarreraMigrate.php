<?php

namespace App\Console\Commands;

use App\Models\ActaVolante;
use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Proceso;
use Illuminate\Console\Command;

class AlumnoCarreraMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:migrateInscripciones';

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
        $progressBar = $this->output->createProgressBar($alumnos->count());

        foreach ($alumnos as $alumno) {
            $alumnoCarreras = AlumnoCarrera::where([
                'alumno_id' => $alumno->id,
            ])->orderBy('created_at', 'desc')->get();

            foreach ($alumnoCarreras as $alumnoCarrera) {
                $alumnoCarrera->update([
                    'fecha_primera_acreditacion' => $alumno->fecha_primera_acreditacion,
                    'fecha_ultima_acreditacion' => $alumno->fecha_ultima_acreditacion,
                    'cohorte' => $alumno->cohorte,
                    'legajo_completo' => $alumno->legajo_completo,
                    'aprobado' => $alumno->aprobado,
                    'regularidad' => $alumno->regularidad
                ]);

                $procesos = Proceso::where([
                    'alumno_id' => $alumno->id,
                    'ciclo_lectivo' => $alumnoCarrera->ciclo_lectivo
                ])->whereHas('materia',function($query)  use ($alumnoCarrera){
                    return $query->where('materias.carrera_id',$alumnoCarrera->carrera_id);
                })->update(['inscripcion_id'=>$alumnoCarrera->id]);

                $actas_volantes = ActaVolante::where([
                    'alumno_id' => $alumno->id
                ])->whereHas('materia',function($query)  use ($alumnoCarrera){
                    return $query->where('materias.carrera_id',$alumnoCarrera->carrera_id);
                })->update(['inscripcion_id'=>$alumnoCarrera->id]);
            }

            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
