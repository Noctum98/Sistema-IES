<?php

namespace App\Console\Commands;

use App\Models\Mesa;
use Illuminate\Console\Command;

class MesasFeriado extends Command
{
    protected $feriados;
    const T_M = '14:00';
    const T_T = '23:59';
    const T_V = '23:59';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mesasFeriados';

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

        $this->feriados = [
            '19-02-2022',
            '20-02-2022',
            '26-02-2022',
            '27-02-2022',
            '28-02-2022',
            '01-03-2022',
            '05-03-2022',
            '06-03-2022',
            '12-03-2022',
            '13-03-2022',
            '09-07-2022',
            '15-08-2022',
            '25-08-2022',
            '02-09-2022',
            '07-10-2022',
            '10-10-2022',
            '20-11-2022',
            '21-11-2022',
            '08-12-2022',
            '09-12-2022',
        ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mesas = Mesa::where([
            'instancia_id'=>12
        ])->get();


        foreach($mesas as $mesa)
        {
            $fecha = date("d-m-Y", strtotime($mesa->fecha));
            $cierre = date("d-m-Y",$mesa->cierre);

            $this->info($fecha.' - '.$cierre);

            /*
            if(in_array($cierre,$this->feriados))
            {
                
            }
           
            $contador = 0;
            
            while($contador <= 2)
            {
                if($this->isHabil($fecha)){
                    $contador++;
                }else{
                    $fecha = date("d-m-Y", strtotime($fecha.'-1 day'));
                }
            }
            $mesa->cierre = strtotime($this->setFechaTurno($mesa->materia,$fecha));
            $mesa->update();
            */
        }
        
    }

    private function isHabil($fecha)
    {
        if(in_array($fecha,$this->feriados) || date('D', strtotime($fecha) == 'Sat') || date('D', strtotime($fecha) == 'Sun')){
            return false;
        }else{
            return true;
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
        return $fecha.'T'.$hora;
    }
}
