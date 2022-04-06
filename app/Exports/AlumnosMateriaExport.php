<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AlumnosMateriaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($procesos)
    {
        $this->procesos = $procesos;
    }

    public function view(): View
    {
        return view('excel.alumnos_materia',[
            'procesos' => $this->procesos
        ]);
    }
}
