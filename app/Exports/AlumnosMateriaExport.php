<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AlumnosMateriaExport implements FromView,WithEvents
{
    use RegistersEventListeners;
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($procesos)
    {
        $this->procesos = $procesos;
    }

    public function view(): View
    {
        return view('excel.alumnos_materia',[
            'procesos' => $this->procesos
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
