<?php

namespace App\Console\Commands;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Comision;
use App\Models\Materia;
use App\Models\Mesa;
use App\Models\Proceso;
use Illuminate\Console\Command;

class ConfigComisiones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:configComisionesUnicas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Confgura comisiones para las carreras que no tenga';

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
        $carreras = Carrera::whereDoesntHave('comisiones')->get();

        foreach ($carreras as $carrera) {
            $años = 3;

            for ($i = 0; $i <= $años; $i++) {
                $comision = Comision::create([
                    'carrera_id' => $carrera->id,
                    'año' => $i,
                    'nombre' => 'Única',
                    'ciclo_lectivo' => 2022
                ]);

                $materias = Materia::where(['carrera_id'=>$carrera->id,'año'=>$i])->get();

                foreach($materias as $materia)
                {
                    $procesos = Proceso::where('materia_id',$materia->id)->get();
                    $profesores = $materia->profesores; 
                    $materia->comisiones()->attach($comision);

                    foreach($procesos as $proceso)
                    {
                        $comision->procesos()->attach($proceso);
                        
                        if(!$comision->hasAlumno($proceso->alumno_id))
                        {
                            $comision->alumnos()->attach(Alumno::find($proceso->alumno_id));
                        }
                    }

                    foreach($profesores as $profesor)
                    {
                        $comision->profesores()->attach($profesor);
                    }
                }
            }
        }
    }
}
