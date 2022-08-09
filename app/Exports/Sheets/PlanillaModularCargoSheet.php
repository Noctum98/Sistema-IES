<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class PlanillaModularCargoSheet implements FromView
{
    private $data_array;
  

    public function __construct($data_array)
    {
        $this->data_array = $data_array;
       
    }


    public function view(): View
    {
        
    }
}
