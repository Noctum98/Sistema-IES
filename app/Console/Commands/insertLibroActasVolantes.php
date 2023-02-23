<?php

namespace App\Console\Commands;

use App\Models\ActaVolante;
use Illuminate\Console\Command;

class insertLibroActasVolantes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertLibroActasVolantes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserta el libro de la mesa en el acta volante';

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
        $actas_volantes = ActaVolante::with('inscripcion')->get();
        
        foreach($actas_volantes as $acta_volante)
        {
            $mesa =  $acta_volante->inscripcion->mesa;

            if($acta_volante->inscripcion->segundo_llamado)
            {
                $libro = $acta_volante->inscripcion->mesa->libro(2,1) ?? null;
            }else{
                $libro = $acta_volante->inscripcion->mesa->libro(1,1) ?? null;

            }

            $acta_volante->libro_id = $libro ? $libro->id : null;
            $acta_volante->update();
        }
       

    }
}
