<?php

namespace App\Console\Commands;

use App\Models\Preinscripcion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        $preinscripciones = Preinscripcion::select('carrera_id', 'dni', DB::raw('MAX(id) as max_id'))
            ->groupBy('carrera_id', 'dni')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $this->info(count($preinscripciones). ' preinscripciones repetidas.');
        $this->output->progressStart(count($preinscripciones));

        foreach ($preinscripciones as $preinscripcion) {
            Preinscripcion::where('carrera_id', $preinscripcion->carrera_id)
                ->where('dni', $preinscripcion->dni)
                ->where('id', '<>', $preinscripcion->max_id)
                ->forceDelete();
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }
}
