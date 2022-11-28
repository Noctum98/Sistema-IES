<?php

namespace App\Console\Commands;

use App\Models\ActaVolante;
use App\Models\Mesa;
use App\Models\MesaAlumno;
use Illuminate\Console\Command;

class RepararActasVolantes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:repararActasVolantes';

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
        $actas_volantes = ActaVolante::all();

        foreach($actas_volantes as $acta_volante)
        {
            if($acta_volante->alumno_id == $acta_volante->mesa_alumno_id)
            {
                $inscripciones = MesaAlumno::where(['alumno_id'=>$acta_volante->alumno_id])->get();

                foreach($inscripciones as $inscripcion)
                {
                    if($acta_volante->materia_id && $inscripcion->mesa_id)
                    {
                        if( $inscripcion->mesa->instancia_id == $acta_volante->instancia_id && $inscripcion->mesa->materia_id == $acta_volante->materia_id){
    
                            $acta_volante->mesa_alumno_id = $inscripcion->id;
                            $acta_volante->update();
                        }
                    }
                }  
            }
        }
    }
}
