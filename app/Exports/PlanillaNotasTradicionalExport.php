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
        // Create Style Arrays
        $default_font_style = [
            'font' => ['name' => 'Arial', 'size' => 10]
        ];

        $strikethrough = [
            'font' => ['strikethrough' => true],
        ];

        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();

        // Apply Style Arrays
        $active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);

        // strikethrough group of cells (A10 to B12) 
        $active_sheet->getStyle('A10:B12')->applyFromArray($strikethrough);
        // or
        $active_sheet->getStyle('A10:B12')->getFont()->setStrikethrough(true);

        // single cell
        $active_sheet->getStyle('A13')->getFont()->setStrikethrough(true);
    }
}
