<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MesaEnrolled extends Mailable
{
    use Queueable, SerializesModels;

    public $inscripcion;
    public $datos;
    public $instancia;
    public $datos_limpios;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos,$instancia,$inscripcion)
    {
        $this->inscripcion = $inscripcion;
        $this->datos = $datos;
        $this->instancia = $instancia;
        $this->datos_limpios = [];
        $this->subject("Mesas IESVU 9015");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        foreach($this->datos as $k => $dato){
            $key = str_replace('_',' ',$k);
            array_push($this->datos_limpios,$key);
            
        }
        
        return $this->view('mail.mesa_enrolled',[
            'datos_limpios'         =>  $this->datos_limpios,
            'instancia'     =>  $this->instancia,
            'inscripcion'   =>  $this->inscripcion
        ]);
    }
}
