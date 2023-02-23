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

    protected $diccionario;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->diccionario = [
            'I' => 1,
            'V' => 5,
            'X' => 10
        ];
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $mesas = Mesa::where('libro', '!=', null)->get();

        foreach ($mesas as $mesa) {
            if ($mesa->libro) {

                Libro::create([
                    'mesa_id' => $mesa->id,
                    'llamado' => 1,
                    'numero' => is_numeric($mesa->libro) ? $mesa->libro : $this->romano_decimal(strtoupper($mesa->libro)) ,
                    'folio' => is_numeric($mesa->folio) ? $mesa->folio : $this->romano_decimal(strtoupper($mesa->folio)),
                    'orden' => 1
                ]);
            }

            if ($mesa->libro_segundo) {
                Libro::create([
                    'mesa_id' => $mesa->id,
                    'llamado' => 2,
                    'numero' => is_numeric($mesa->libro_segundo) ? $mesa->libro_segundo : $this->romano_decimal(strtoupper($mesa->libro_segundo)) ,
                    'folio' => is_numeric($mesa->folio_segundo) ? $mesa->folio_segundo : $this->romano_decimal(strtoupper($mesa->folio_segundo)),
                    'orden' => 1
                ]);
            }
        }
    }

    private function romano_decimal($var)
    {  
        $suma = 0;
        $var = strtoupper($var);
        $var = mb_ereg_replace("[^IVXLCDM]", "", $var);
        # Definición de variables
        $numeroletrasromanas = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50, "X" => 10, "V" => 5, "I" => 1);
        $parcialfinal = 1001;
        for ($inicio = 0; $inicio < strlen($var); $inicio++) {
            $parcial = substr($var, $inicio, 1);
            $parcial = $numeroletrasromanas[$parcial];
            if ($parcial <= $parcialfinal) {
                $suma .= "+$parcial";
            } else {
                $suma .= "+" . ($parcial - (2 * $parcialfinal));
            }
            $parcialfinal = $parcial;
        }
        eval("\$suma=$suma;");
        return $suma;
    }
}
