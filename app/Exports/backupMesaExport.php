<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class backupMesaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($inscripciones)
    {
        $this->inscripciones = $inscripciones;
    }

    public function view(): View{
        return view('excel.mesas',[
            'inscripciones' => $this->inscripciones
        ]);
    }
}
