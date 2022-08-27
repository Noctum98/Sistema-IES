<?php

namespace App\Console\Commands;

use App\Models\Preinscripcion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class deletePreinscripciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:Preinscripciones';

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
        $this->info('Command -> deletePreinscripciones Iniciado');

        $preinscripciones = Preinscripcion::truncate();

        $this->info('Command -> deletePreinscripciones Terminado');
    }
}
