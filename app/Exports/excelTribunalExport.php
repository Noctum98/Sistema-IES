<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class excelTribunalExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($carrera,$instancia)
    {
        $this->carrera = $carrera;
        $this->instancia = $instancia;
    }

    public function view(): View{
        $mesas = [];
        foreach($this->carrera->materias as $materia){
            foreach($materia->mesas as $mesa){
                if($mesa->instancia_id == $this->instancia->id)
                {
                    array_push($mesas,$mesa);
                }
            }
        }

        return view('excel.tribual_mesa',[
            'mesas' => $mesas
        ]);
    }
}