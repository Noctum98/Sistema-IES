<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class insertRolCargo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertRolCargos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command:insertRolCargos';

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
        DB::table('roles')->insert([
            'nombre' => 'cargos',
            'descripcion' => 'Cargos',
            'tipo' => 1
        ]);
    }
}
