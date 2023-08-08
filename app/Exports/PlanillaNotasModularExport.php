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

    public function __construct(Materia $materia,$procesos)
    {
        $this->materia = $materia;
        $this->procesos = $procesos;
    }

    public function sheets(): array
    {
        $data_array = [
            'materia'=> $this->materia,
            'procesos' => $this->procesos
        ];
        
        $sheets[] = new PlanillaModularCargoSheet($data_array);
        return $sheets;
    }
}
