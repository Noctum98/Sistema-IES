<?php

namespace App\Console\Commands;

use App\Models\ActaVolante;
use App\Models\Libro;
use App\Models\Mesa;
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
        $mesas = Mesa::where('libro','!=',null)->get();

        foreach($mesas as $mesa)
        {
            if($mesa->libro)
            {
                Libro::create([
                    'mesa_id'=> $mesa->id,
                    'llamado'=> 1,
                    'numero' => $mesa->libro,
                    'folio' => $mesa->folio,
                    'orden' => 1
                ]);
            }

            if($mesa->libro_segundo)
            {
                Libro::create([
                    'mesa_id'=> $mesa->id,
                    'llamado'=> 2,
                    'numero' => $mesa->libro_segundo,
                    'folio' => $mesa->folio_segundo,
                    'orden' => 1
                ]);
            }
        }
    }
}
