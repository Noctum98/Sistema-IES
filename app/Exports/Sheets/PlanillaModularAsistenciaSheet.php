<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class PlanillaModularAsistenciaSheet implements FromView, WithTitle,WithEvents
{
    use RegistersEventListeners;

    protected $cargos;
    protected $procesos;
    protected $materia;

    public function __construct($cargos,$procesos,$materia)
    {
        $this->cargos = $cargos;
        $this->procesos = $procesos;
        $this->materia = $materia;
       
    }


    public function view(): View
    {

        $cargos = $this->cargos;
        

        return view('excel.planilla_asistencias_modular',[
            'cargos' => $this->cargos,
            'procesos' => $this->procesos,
            'materia' => $this->materia
        ]);
    }

    public function title(): string
    {
        return "Asistencias";
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();
        $active_sheet->getColumnDimension('A')->setAutoSize(true);
        foreach(range('B','Z') as $columnID) {
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

