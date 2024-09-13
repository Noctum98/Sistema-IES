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
        $inscripciones = AlumnoCarrera::where('cohorte',null)->get();
        $progressBar = $this->output->createProgressBar($inscripciones->count());

        foreach ($inscripciones as $inscripcion) {
            
            $inscrpicionO = AlumnoCarrera::where([
                'alumno_id' => $inscripcion->alumno_id,
                'carrera_id' => $inscripcion->carrera_id
            ])->where('cohorte','!=',null)->first();
    
            if($inscrpicionO)
            {
                $inscripcion->cohorte = $inscrpicionO->cohorte;
                $inscripcion->update();
            }

            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
