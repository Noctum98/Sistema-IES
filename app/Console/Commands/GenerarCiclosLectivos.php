<?php

namespace App\Console\Commands;

use App\Models\Parameters\CicloLectivo;
use Illuminate\Console\Command;

class GenerarCiclosLectivos extends Command
{

    const CICLO_LECTIVO_INICIAL =  1986;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generar:ciclos-lectivos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar las fechas de cada ciclo lectivo desde que se creo el IESVU 03-06-1986';

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

        $this->info('Iniciando commando ');
        $this->info($this->description);
        $this->info('Procesando...');

        $cicloFinal = date('Y');
        $cantidad = $cicloFinal - self::CICLO_LECTIVO_INICIAL;
        $this->output->progressStart($cantidad);
        for($i = self::CICLO_LECTIVO_INICIAL; $i <= $cicloFinal; $i++){
            $ciclo = CicloLectivo::find($i);
            if(!$ciclo){
                $ciclo = new CicloLectivo();
                $ciclo->crearCicloLectivo($i);
            }

            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        $this->info('Se procesaron ' . $cantidad . ' ciclos lectivos');

        return Command::SUCCESS;
    }
}
