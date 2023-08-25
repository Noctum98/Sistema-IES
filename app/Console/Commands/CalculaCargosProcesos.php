<?php

namespace App\Console\Commands;

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
        $cantProcesosModulares = ProcesoModular::max('id');

        $paginas = round($cantProcesosModulares / 100, PHP_ROUND_HALF_UP);
        $cantidad = $cantProcesosModulares;
        $inicio = 1;
        $fin = 100;
        $this->output->progressStart($cantidad);
        for($i = 0; $i < $paginas; $i++){


            $procesosModulares = ProcesoModular::where('id', '>' , $inicio )
                ->orderBy('id', 'ASC')
                ->paginate(100);


            $this->info(' Total procesos modulares: ' . $cantidad . ' ');


            $user = $this->option('id_user');
            $ppc = 0;
            foreach ($procesosModulares as $modulare) {

                if($modulare->procesoRelacionado()->first()) {
                    $cargos = $modulare->procesoRelacionado()->first()->materia()->first()->cargos()->get();


                    if ($modulare->ciclo_lectivo and $modulare->ciclo_lectivo > 0) {
                        foreach ($cargos as $cargo) {
                            try {
                                $this->cargoProcesoService->grabaNotaPonderadaCargo($cargo->id, $modulare->ciclo_lectivo, $modulare->proceso_id, $modulare->procesoRelacionado()->first()->materia_id, $user);
                            } catch (Exception $e) {
                                $cantidad -= $cantidad;
                                $this->info('Error en: ' . $e->getMessage());

                            }
                        }
                    } else {
                        $this->info('El proceso ' . $modulare->id . ' no tiene ciclo_lectivo');
                    }
                }


                $this->output->progressAdvance();
            }

            $inicio +=100;
            $fin +=100;

        }




        $this->output->progressFinish();
        $this->info('Se procesaron ' . $cantidad . ' procesos modulares');
        $this->info('Commando finalizado');
    }
}
