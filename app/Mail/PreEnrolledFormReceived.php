<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PreEnrolledFormReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($preinscripcion)
    {
        $this->preinscripcion = $preinscripcion;
        $this->subject("Preinscripción IESVU 9015");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $titulo = 'Preinscripción: '.$this->preinscripcion->nombres.' '.$this->preinscripcion->apellidos;
        return $this->view('mail.pre_enrolled',[
            'preinscripcion' => $this->preinscripcion,
            'titulo'         => $titulo
        ]);
    }
}
