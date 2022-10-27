<?php

namespace App\Console\Commands;

use App\Models\Preinscripcion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EliminarPreinscripcionesRepetidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:EliminarPreinscripcionesRepetidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina todas la preinscripciones repetidas';

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
        $preinscripciones = Preinscripcion::all();

        foreach($preinscripciones as $preinscripcion)
        {
            foreach($preinscripciones as $preinscripcionOtra)
            {
                if($preinscripcionOtra->id != $preinscripcion->id && $preinscripcionOtra->carrera_id == $preinscripcion->carrera_id && $preinscripcionOtra->dni == $preinscripcion->dni)
                {
                    $this->info($preinscripcion->id.' repetida:'.$preinscripcionOtra->id);
                    Log::info($preinscripcion->id.' repetida:'.$preinscripcionOtra->id);
                }
            }
        }
    }
}
