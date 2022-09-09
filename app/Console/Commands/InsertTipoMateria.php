<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertTipoMateria extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:tipo_materia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta tipo materias';

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
     * @return string
     */
    public function handle(): string
    {
        DB::table('tipo_materias')->insert([
            'nombre' => "Taller Práctica Profesional",
            'identificador' => "1",
        ]);

        return 'Proceso terminado';
    }
}
