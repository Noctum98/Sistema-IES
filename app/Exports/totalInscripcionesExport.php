<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class totalInscripcionesExport implements FromView
{
  
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($carreras)
    {
        $this->carreras = $carreras;
        $this->instancia = session('instancia');
    }

    public function view(): View{

        return view('excel.total_inscripciones_mesas',[
            'carreras' => $this->carreras,
            'instancia' => $this->instancia
        ]);
    }
}
