<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AllAlumnosExport implements FromView,WithEvents
{
    use RegistersEventListeners;


    public $alumnos;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($alumnos)
    {
        $this->alumnos = $alumnos;
    }

    public function view(): View
    {
        return view('excel.all_alumnos',[
            'alumnos' => $this->alumnos
        ]);
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();
        foreach(range('A','H') as $columnID) {
            $active_sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

    }
}
