<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class excelTribunalExport implements FromView,WithEvents
{
    use RegistersEventListeners;
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