<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AlumnosYearExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($alumnos,$generos)
    {
        $this->alumnos = $alumnos;
        $this->generos = $generos;
    }

    public function view(): View
    {
        return view('excel.alumnos_year',[
            'alumnos' => $this->alumnos,
            'generos' => $this->generos
        ]);
    }
}
