<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AlumnosDatosExport implements FromView
{
    
    protected $alumnos;

    public function __construct($alumnos)
    {
        $this->alumnos = $alumnos;
    }

    public function view(): View
    {
        return view('excel.alumnos_datos',[
            'alumnos' => $this->alumnos
        ]);
    }
}
