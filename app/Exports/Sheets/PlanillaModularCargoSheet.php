<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class PlanillaModularCargoSheet implements FromView, WithTitle, WithEvents
{
    use RegistersEventListeners;
    public $data_array;


    public function __construct($data_array)
    {
        $this->data_array = $data_array;
    }


    public function view(): View
    {
        return view('excel.planilla_notas_modular', [
            'materia' => $this->data_array['materia'],
            'procesos' => $this->data_array['procesos']
        ]);
    }

    public function title(): string
    {
        return 'Planilla Módulo';
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();
        $active_sheet->getColumnDimension('A')->setAutoSize(true);
        foreach (range('B', 'G') as $columnID) {
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
        $active_sheet->getStyle('A4:F4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('46bdc6');
        $active_sheet->getStyle('A4:G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('46bdc6');

        $active_sheet->getStyle('A1:B1')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A2:B2')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A3:B3')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A4:F4')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A4:F4')->getAlignment()->setWrapText(true);
        $active_sheet->getStyle('A2:B2')->getAlignment()->setWrapText(true);
    }
}
