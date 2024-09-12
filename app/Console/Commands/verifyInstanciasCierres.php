<?php

namespace App\Console\Commands;

use App\Models\Instancia;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class verifyInstanciasCierres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:verifyInstanciasCierres';

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
        $instancias = Instancia::all();
        $fechaActual = Carbon::now(); // Obtiene la fecha y hora actual

        foreach ($instancias as $instancia) {
            $this->verifyCierres($instancia);
        }

        Log::info('Instancias Actualizadas');
    }

    public function verifyCierres($instancia)
    {
        $fechaActual = Carbon::now(); // Obtiene la fecha y hora actual
        $data = [
            'estado' => 'inactiva',
            'cierre' => true
        ];

        if ($instancia->fecha_habilitacion) {
            // Verificar si está activo
            if (Carbon::parse($instancia->fecha_habilitacion)->lte($fechaActual) && Carbon::parse($instancia->fecha_cierre)->gte($fechaActual)) {
                $data['estado'] = 'activa';
            }

            // Verificar si está en bajas
            if (Carbon::parse($instancia->fecha_bajas)->lte($fechaActual) && Carbon::parse($instancia->fecha_cierre_bajas)->gte($fechaActual)) {
                $data['cierre'] = false;
            }

            $instancia->update($data);

        }

        return $instancia;
    }
}
