<?php

namespace App\Console\Commands;

use App\Models\Carrera;
use Illuminate\Console\Command;

class linksPreinscripciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:preinscripciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera Links de Preinscripciones';

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
        $carreras = Carrera::where('estado',null)->orderBy('sede_id')->get();

        foreach($carreras as $carrera)
        {
            $this->info($carrera->nombre.'('.$carrera->turno.') - '.$carrera->sede->nombre.': ');
            $this->info('https://data-iesvu.iesvu.edu.ar/preinscripcion/'.$carrera->id);
        }
    }
}
