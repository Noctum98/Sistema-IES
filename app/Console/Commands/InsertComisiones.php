<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertComisiones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertComisiones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta comisiones';

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
        DB::table('comisiones')->insert([
            'carrera_id' => 23,
            'año' => 1,
            'nombre' => "Comisión A - Primer Año"
        ]);

        DB::table('comisiones')->insert([
            'carrera_id' => 23,
            'año' => 1,
            'nombre' => "Comisión B - Primer Año"
        ]);
    }
}
