<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FileErrorForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($preinscripcion,$datos)
    {
        $this->preinscripcion = $preinscripcion;
        $this->subject("Error en Preinscripci¨®n IESVU 9015");
        $this->archivos = $datos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.file_error',[
            'archivos' => $this->archivos,
            'preinscripcion'    =>  $this->preinscripcion
        ]);
    }
}

