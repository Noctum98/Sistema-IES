<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InstertRolProfesor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertRolProfesor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta el ROl Profesor';

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
            'nombre' => 'profesor',
            'descripcion' => 'Profesor',
            'tipo' => 0
        ]);
    }
}
