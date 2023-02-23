<?php

namespace App\Console\Commands;

use App\Models\Preinscripcion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class preinscripcionesRepetidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:preinscripcionesRepetidas';

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
        $preinscripciones_repetidas = DB::select('SELECT dni,carrera_id, count(*) as cantidad FROM `preinscripciones` group by dni,carrera_id having count(*) >1 order by cantidad DESC');
        foreach($preinscripciones_repetidas as $preinscripcion_repetida)
        {
            $preinscripciones = Preinscripcion::where([
                'dni'=>$preinscripcion_repetida->dni,
                'carrera_id' => $preinscripcion_repetida->carrera_id
            ])->get();

            $preinscripcion_ok = $preinscripciones->first();

            foreach($preinscripciones as $preinscripcion)
            {
                if($preinscripcion->id != $preinscripcion_ok->id)
                {
                    $preinscripcion->delete();
                }
            }
        }
    }
}
