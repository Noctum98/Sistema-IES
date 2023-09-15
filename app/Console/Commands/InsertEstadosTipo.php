<?php

namespace App\Console\Commands;

use App\Models\Estados;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertEstadosTipo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertTiposEstados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta tipos de estado';

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
     *
     */
    public function handle()
    {

        DB::table('estados')->insert([
            'nombre' => "Regular - Global",
            'identificador' => "7",
            'regularidad' => "Regular"
        ]);
       $estados = Estados::all();

        $this->info(' Iniciando carga de tipos de estados.');
        $this->output->progressStart(count($estados));

        foreach ($estados as $estado) {

            if(in_array($estado->identificador, [1,3,4,7])){
                $estado->regularidad = 'Regular';
            }else{
                $estado->regularidad = 'No Regular';
            }

            $estado->update();
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        $this->info(' Finaliza carga de tipos de estados.');

    }
}
