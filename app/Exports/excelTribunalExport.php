<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class excelTribunalExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($carrera)
    {
        $this->carrera = $carrera;
    }

    public function view(): View{
        $mesas = [];
        foreach($this->carrera->materias as $materia){
            foreach($materia->mesas as $mesa){
                array_push($mesas,$mesa);
            }
        }

        return view('excel.tribual_mesa',[
            'mesas' => $mesas
        ]);
    }
}