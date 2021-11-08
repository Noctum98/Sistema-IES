<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

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
}
