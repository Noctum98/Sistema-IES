<?php

namespace App\Exports;

use App\Models\Preinscripcion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PreinscripcionExport implements FromView,WithEvents
{
    use RegistersEventListeners;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(int $carrera_id,$verificados = null){
        $this->carrera_id = $carrera_id;
        $this->verificados = $verificados;
    }

    public function view(): View
    {
        if($this->verificados){
            $preinscripciones = Preinscripcion::orderBy('updated_at','ASC')->where('estado','verificado')->get();
        }else{
            $preinscripciones = Preinscripcion::where('carrera_id',$this->carrera_id)->get();
        }
        
        return view('excel.preinscripciones',[
            'preinscripciones'=>$preinscripciones
        ]);
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();
        foreach(range('A','H') as $columnID) {
            $active_sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

    }
}
