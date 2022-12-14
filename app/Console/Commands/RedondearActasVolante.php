<?php

namespace App\Console\Commands;

use App\Models\ActaVolante;
use Illuminate\Console\Command;

class RedondearActasVolante extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:redondearActasVolantes';

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
        $actas_volantes = ActaVolante::select('id','promedio')->get();

        foreach($actas_volantes as $acta_volante)
        {
            $acta_volante->promedio = round($acta_volante->promedio,0,PHP_ROUND_HALF_UP);
            $acta_volante->update();
        }
    }
}
