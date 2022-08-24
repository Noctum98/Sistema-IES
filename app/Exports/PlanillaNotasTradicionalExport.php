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
        $materia = $this->procesos[0]->materia;
        return view('excel.planilla_notas_tradicional',[
            'carrera' => $this->carrera,
            'procesos' => $this->procesos,
            'calificaciones' => $this->calificaciones,
            'materia' => $materia
        ]);
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();
        $active_sheet->getColumnDimension('A')->setAutoSize(true);
        foreach (range('B', 'Z') as $columnID) {
            $active_sheet->getColumnDimension($columnID)
                ->setWidth('25');
        }

        $active_sheet->getRowDimension('1')->setRowHeight(40);
        $active_sheet->getRowDimension('2')->setRowHeight(40);
        $active_sheet->getRowDimension('3')->setRowHeight(40);
        $active_sheet->getRowDimension('4')->setRowHeight(40);
        $active_sheet->getStyle('A1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fbbc04');
        $active_sheet->getStyle('A2:B2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fbbc04');
        $active_sheet->getStyle('A3:B3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fbbc04');
        $active_sheet->getStyle('A4:Z4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('46bdc6');

        $active_sheet->getStyle('A1:B1')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A2:B2')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A3:B3')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A4:Z4')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A4:Z4')->getAlignment()->setWrapText(true);
        $active_sheet->getStyle('A2:B2')->getAlignment()->setWrapText(true);

    }
}
