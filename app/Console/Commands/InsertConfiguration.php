<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertConfiguration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea configuración general';

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
     * @return void
     */
    public function handle(): void
    {
        DB::table('configuration')->insert([
            'asistencia_ponderada' => false,
            'proceso_ponderado' => true,
        ]);

    }
}
