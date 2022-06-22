<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertEstados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertEstados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta estados';

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
    public function handle(): string
    {
        DB::table('estados')->insert([
            'nombre' => "Regular",
            'identificador' => "1",
        ]);
        DB::table('estados')->insert([
            'nombre' => "No Regular",
            'identificador' => "2",
        ]);
        DB::table('estados')->insert([
            'nombre' => "Regular - Anticipada",
            'identificador' => "3",
        ]);
        DB::table('estados')->insert([
            'nombre' => "Regular - Directa",
            'identificador' => "4",
        ]);
        DB::table('estados')->insert([
            'nombre' => "No Regular - Global",
            'identificador' => "5",
        ]);

        return 'Proceso terminado';
    }
}
