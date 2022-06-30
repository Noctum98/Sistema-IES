<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertTipoCalificacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertTiposCalificaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta Tipos de Calificaciones';

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
        DB::table('tipo_calificaciones')->insert([
            'nombre' => "Parcial",
            'descripcion' => "1",
        ]);
        DB::table('tipo_calificaciones')->insert([
            'nombre' => "TP (Trabajo Práctico)",
            'descripcion' => "2",
        ]);
        DB::table('tipo_calificaciones')->insert([
            'nombre' => "EIFM (Trabajo Integrador Final)",
            'descripcion' => "3",
        ]);

        return 'Proceso terminado';
    }
}
