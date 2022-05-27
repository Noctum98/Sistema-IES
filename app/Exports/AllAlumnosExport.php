<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AllAlumnosExport implements FromView
{

    public $carreras;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($carreras)
    {
        $this->carreras = $carreras;
    }

    public function view(): View
    {
        return view('excel.all_alumnos',[
            'carreras' => $this->carreras
        ]);
    }
}
