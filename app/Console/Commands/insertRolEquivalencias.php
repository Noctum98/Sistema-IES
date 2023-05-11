<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class insertRolEquivalencias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertRolEquivalencias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command:insertRolEquivalencias';

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

        DB::table('roles')->insert([
            'nombre' => 'equivalencias',
            'descripcion' => 'Equivalencias Manager',
            'tipo' => 1
        ]);
        $this->line('<fg=green;bg=black>Commando terminado.</>');
    }
}
