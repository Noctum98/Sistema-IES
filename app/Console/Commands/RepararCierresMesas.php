<?php

namespace App\Console\Commands;

use App\Models\Instancia;
use App\Models\Mesa;
use App\Models\Parameters\Calendario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RepararCierresMesas extends Command
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
    protected $signature = 'command:repararCierresMesas {instancia_id} {llamado}';

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
        $instancia_id = (int) $this->argument('instancia_id');
        $llamado = (int) $this->argument('llamado');
        $instancia = Instancia::find($instancia_id);
        $feriados = Calendario::all();
        $this->feriados = $this->limpiarFeriados($feriados,$instancia);

        $mesas = Mesa::where('instancia_id', $instancia_id)->get();

        foreach ($mesas as $mesa) {
            if($llamado == 1){
                $inicio_fecha = date("d-n-Y", strtotime($mesa->fecha.'-1 day'));
                $this->isHabil($inicio_fecha);

                $contador = 0;
                while ($contador < 2) {
                    
                    if ($this->isHabil($inicio_fecha)) {
                        $contador++;
                    }
    
                    if($contador != 2){
                        $inicio_fecha = date("d-n-Y", strtotime($inicio_fecha . '-1 day'));
                    }
                }
                $mesa->cierre = strtotime($this->setFechaTurno($mesa->materia,$inicio_fecha));
                $mesa->update();
            }else{
                $inicio_fecha = date("d-n-Y", strtotime($mesa->fecha_segundo.'-1 day'));
                $contador = 0;
                while ($contador < 2) {
                    
                    if ($this->isHabil($inicio_fecha)) {
                        $contador++;
                    }
    
                    if($contador != 2){
                        $inicio_fecha = date("d-n-Y", strtotime($inicio_fecha . '-1 day'));
                    }
                }
                $mesa->cierre_segundo = strtotime($this->setFechaTurno($mesa->materia,$inicio_fecha));
                $mesa->update();
            }

        }
    }

    private function isHabil($fecha)
    {
        if (in_array($fecha, $this->feriados) || date('D', strtotime($fecha))  == 'Sat' || date('D', strtotime($fecha)) == 'Sun') {
            return false;
        } else {
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
        
        return $fecha . 'T' . $hora;
    }

    private function limpiarFeriados($feriados,$instancia)
    {
        $feriadosLimpios = [];
        foreach($feriados as $feriado)
        {
            $feriadoLimpio = $feriado->dia.'-'.$feriado->mes.'-'.$instancia->año;
            array_push($feriadosLimpios,$feriadoLimpio);
        }

        return $feriadosLimpios;
    }
}
