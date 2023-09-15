<?php

namespace App\Exports;

use App\Exports\Sheets\PlanillaModularAlumnosSheet;
use App\Exports\Sheets\PlanillaModularAsistenciaSheet;
use App\Exports\Sheets\PlanillaModularCargoSheet;
use App\Models\Materia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PlanillaNotasModularExport implements WithMultipleSheets
{
    private $materia;
    private $procesos;
    private $ciclo_lectivo;

    public function __construct(Materia $materia,$procesos,$ciclo_lectivo)
    {
        $this->materia = $materia;
        $this->procesos = $procesos;
        $this->ciclo_lectivo = $ciclo_lectivo;
    }

    public function sheets(): array
    {
        $data_array = [
            'materia'=> $this->materia,
            'procesos' => $this->procesos,
            'ciclo_lectivo' => $this->ciclo_lectivo
        ];
        
        $sheets[] = new PlanillaModularCargoSheet($data_array);

        
        foreach($this->materia->cargos as $cargo)
        {
            $data_array['cargo'] = $cargo;
            $sheets[] = new PlanillaModularAlumnosSheet($data_array);
        }

        return $sheets;
    }
}
