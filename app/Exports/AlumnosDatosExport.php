<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AlumnosDatosExport implements FromView,WithEvents
{
    use RegistersEventListeners;
    
    protected $alumnos;
    protected $carrera;

    public function __construct($alumnos,$carrera)
    {
        $this->alumnos = $alumnos;
        $this->carrera = $carrera;
    }

    public function view(): View
    {
        return view('excel.alumnos_datos',[
            'alumnos' => $this->alumnos,
            'carrera' => $this->carrera
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
