<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class mesaAlumnosExport implements FromView, WithEvents
{
    use RegistersEventListeners;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($inscripciones, $materia)
    {
        $this->materia = $materia;
        $this->inscripciones = $inscripciones;
    }

    public function view(): View
    {
        return view('excel.mesas', [
            'inscripciones' => $this->inscripciones,
            'materia' => $this->materia
        ]);
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();
        foreach (range('A', 'E') as $columnID) {
            $active_sheet->getColumnDimension($columnID)
                ->setWidth('25');
        }

        $active_sheet->getColumnDimension('F')->setWidth('8');
        $active_sheet->getColumnDimension('G')->setWidth('8');
        $active_sheet->getColumnDimension('H')->setWidth('13');

        $active_sheet->getStyle('A1:B1')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A2:C2')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A3:C3')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A4:C4')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A5:C5')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $active_sheet->getStyle('A6:H6')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);


        foreach (range('A', 'H') as $row) {
            foreach (range(7, 30) as $columnID) {


                $active_sheet->getStyle($row . $columnID)->getBorders()
                    ->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                $active_sheet->getStyle($row . $columnID)->getBorders()
                    ->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $active_sheet->getStyle($row . $columnID)->getBorders()
                    ->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $active_sheet->getRowDimension($columnID)->setRowHeight(30);

                if(($row == 'F' || $row == 'G' || $row == 'H') )
                {
                    $active_sheet->getStyle($row . $columnID)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                }
            }
        }

        $active_sheet->getRowDimension('1')->setRowHeight(40);
        $active_sheet->getRowDimension('2')->setRowHeight(40);
        $active_sheet->getRowDimension('3')->setRowHeight(40);
        $active_sheet->getRowDimension('6')->setRowHeight(30);

        $active_sheet->getStyle('A2:H2')->getAlignment()->setWrapText(true);
        $active_sheet->getStyle('A3:H3')->getAlignment()->setWrapText(true);
        $active_sheet->getStyle('A5:H5')->getAlignment()->setWrapText(true);
    }
}
