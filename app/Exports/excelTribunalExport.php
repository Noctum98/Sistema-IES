<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class excelTribunalExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($mesas)
    {
        $this->mesas = $mesas;
    }

    public function view(): View{
        return view();
    }
}