<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PlanillaNotasTradicionalExport implements FromView
{
    public $procesos;
    public $calificaciones;

    public function __construct($procesos,$calificaciones)
    {
        $this->procesos = $procesos;
        $this->calificaciones = $calificaciones;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excel.planilla_notas_tradicional',[
            'procesos' => $this->procesos,
            'calificaciones' => $this->calificaciones
        ]);
    }
}
