<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class totalInscripcionesExport implements FromView,WithEvents
{
    use RegistersEventListeners;
  
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($carreras)
    {
        $this->carreras = $carreras;
        $this->instancia = session('instancia');
    }

    public function view(): View{

        return view('excel.total_inscripciones_mesas',[
            'carreras' => $this->carreras,
            'instancia' => $this->instancia
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
