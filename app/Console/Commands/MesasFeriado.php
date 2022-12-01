<?php

namespace App\Console\Commands;

use App\Models\Mesa;
use Illuminate\Console\Command;

class MesasFeriado extends Command
{
    protected $feriados;
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
        $mesas = Mesa::where('instancia_id',12)->get();

        foreach($mesas as $mesa)
        {
            $fecha_dia_segundo = date("d-m-Y", strtotime($mesa->fecha_segundo));

            $comp_segundo_llamado = in_array($fecha_dia_segundo, $this->feriados);
        }
    }
}
