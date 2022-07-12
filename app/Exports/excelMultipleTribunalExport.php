<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;

class excelMultipleTribunalExport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($sede = null,$sedes = null){
        $this->sede = $sede;
        $this->sedes = $sedes;
    }


    public function sheets(): array
    {
        $sheets = [];

        if($this->sede){
            foreach($this->sede->carreras as $carrera){
                $sheets[] = new excelTribunalExport($carrera);
            }
        }else{
            foreach($this->sedes as $sede){
                foreach($sede->carreras as $carrera){
                    $sheets[] = new excelTribunalExport($carrera);
                }
            }
        }
        return $sheets;
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();
        foreach(range('A','Z') as $columnID) {
            $active_sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

    }
}
