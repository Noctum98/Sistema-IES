<?php

namespace App\Console\Commands;

use App\Models\Mesa;
use Illuminate\Console\Command;

class RepararCierresMesas extends Command
{

    const T_M = '14:00';
    const T_T = '23:59';
    const T_V = '23:59';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:repararCierresMesas';

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
        $mesas = Mesa::where('instancia_id', 12)->get();

        foreach ($mesas as $mesa) {
            $materia = $mesa->materia;
            if ($mesa->fecha_segundo) {
                if ($mesa->fecha_segundo && date('D', strtotime($mesa->fecha_segundo)) == 'Mon' || date(
                    'D',
                    strtotime($mesa->fecha_segundo)
                ) == 'Tue') {

                    $mesa->cierre_segundo = strtotime($this->setFechaTurno($materia, $mesa->fecha_segundo) . "-4 days");
                } else {
                    $mesa->cierre_segundo = strtotime($this->setFechaTurno($materia, $mesa->fecha_segundo) . "-2 days");
                }
            } 
            $mesa->update();
        }
    }

    private function setFechaTurno($materia, $fecha)
    {

        $turno = $materia->carrera->turno;
        $hora = '00:00';
        switch ($turno) {
            case 'mañana':
                $hora = $this::T_M;
                break;
            case 'tarde':
                $hora = $this::T_T;
                break;
            case 'vespertino':
                $hora = $this::T_V;
        }

        $fecha_inicial = substr($fecha, 0, -5);

        return $fecha_inicial.$hora;
    }
}
