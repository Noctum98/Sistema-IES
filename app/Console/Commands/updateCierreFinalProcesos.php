<?php

namespace App\Console\Commands;

use App\Models\Proceso;
use Illuminate\Console\Command;

class updateCierreFinalProcesos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateCierreFinalProcesos';

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
        $procesoUpdate = Proceso::where('cierre',true)->where('ciclo_lectivo','<',2024)->update(['cierre_final'=>true]);

        $this->info('Procesos Actualizados');
    }
}
