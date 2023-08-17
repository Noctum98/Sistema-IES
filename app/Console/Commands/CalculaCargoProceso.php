<?php

namespace App\Console\Commands;

use App\Models\Proceso;
use Illuminate\Console\Command;

class CalculaCargoProceso extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:redondearProcesos';

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
        $procesos = Proceso::all();

        foreach($procesos as $proceso)
        {
            if($proceso->final_trabajos)
            {
                $proceso->final_trabajos = round($proceso->final_trabajos,0,PHP_ROUND_HALF_UP);
            }

            if($proceso->porcentaje_final_trabajos)
            {
                $proceso->porcentaje_final_trabajos = round($proceso->porcentaje_final_trabajos,0,PHP_ROUND_HALF_UP);
            }

            $proceso->update();

        }
    }
}
