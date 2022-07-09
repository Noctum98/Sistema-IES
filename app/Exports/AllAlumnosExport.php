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


    public $carreras;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($carreras)
    {
        $this->carreras = $carreras;
    }

    public function view(): View
    {
        return view('excel.all_alumnos',[
            'carreras' => $this->carreras
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
