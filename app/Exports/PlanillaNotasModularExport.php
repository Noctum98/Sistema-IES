<?php

namespace App\Exports;

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

        $sheets = [];
        $sheets[] = new PlanillaModularAsistenciaSheet($this->materia->cargos,$this->procesos,$this->materia);

        foreach($this->materia->cargos as $cargo)
        {
            $data_array = [
                'materia' => $this->materia,
                'cargo' => $cargo,
                'procesos' => $this->procesos
            ];  
            
            $sheets[] = new PlanillaModularCargoSheet($data_array);
        }

        return $sheets;
    }
}
