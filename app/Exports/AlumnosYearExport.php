<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AlumnosYearExport implements FromView,WithEvents
{
    use RegistersEventListeners;

    public $alumnos;
    public $generos;
    public $ciclo_lectivo;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($alumnos,$generos,$ciclo_lectivo)
    {
        $this->alumnos = $alumnos;
        $this->generos = $generos;
        $this->ciclo_lectivo = $ciclo_lectivo;
    }

    public function view(): View
    {
        return view('excel.alumnos_year',[
            'alumnos' => $this->alumnos,
            'generos' => $this->generos,
            'ciclo_lectivo' => $this->ciclo_lectivo
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
