<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PlanillaNotasTradicionalExport implements FromView,WithEvents
{
    public $procesos;
    public $calificaciones;
    public $carrera;

    use RegistersEventListeners;


    public function __construct($procesos,$calificaciones,$carrera)
    {
        $this->procesos = $procesos;
        $this->calificaciones = $calificaciones;
        $this->carrera = $carrera;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excel.planilla_notas_tradicional',[
            'carrera' => $this->carrera,
            'procesos' => $this->procesos,
            'calificaciones' => $this->calificaciones
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
