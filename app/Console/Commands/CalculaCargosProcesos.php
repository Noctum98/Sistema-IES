<?php

namespace App\Console\Commands;

use App\Models\Proceso;
use App\Models\ProcesoModular;
use App\Services\CargoProcesoService;
use Exception;
use Illuminate\Console\Command;

class CalculaCargosProcesos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:calculaCargosProcesos {--id_user=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcula las notas de los Cargos según los Procesos y los graba en la tabla intermedia de CargoProceso';
    /**
     * @var CargoProcesoService
     */
    private $cargoProcesoService;

    /**
     * Create a new command instance.
     *
     * @param CargoProcesoService $cargoProcesoService
     */
    public function __construct(CargoProcesoService $cargoProcesoService)
    {
        parent::__construct();
        $this->cargoProcesoService = $cargoProcesoService;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->info('Iniciando commando ');
        $this->info($this->description);
        $this->info('Procesando...');
        $procesosModulares = ProcesoModular::all();
$cantidad = count($procesosModulares);
        $this->info(' Total procesos modulares: ' . $cantidad . ' ');
        $user = $this->option('id_user');

        foreach ($procesosModulares as $modulare) {

            $cargos = $modulare->procesoRelacionado()->first()->cargos()->get();

            foreach ($cargos as $cargo) {
                try {
                    $this->cargoProcesoService->grabaNotaPonderadaCargo($cargo->id, $modulare->ciclo_lectivo, $modulare->proceso_id, $modulare->procesoRelacionado()->first()->materia_id, $user);
                }
                catch (Exception $e){
                    $cantidad -= $cantidad;
                    $this->info('Error en: ' . $e->getMessage());

                }
            }

        }


        $this->info('Se procesaron ' . $cantidad . ' procesos modulares');
        $this->info('Commando finalizado');
    }
}
