<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FileErrorForm extends Mailable
{
    use Queueable, SerializesModels;
    public $preinscripcion;
    public $archivos;
    public $mailService;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($preinscripcion,$datos)
    {
        $this->preinscripcion = $preinscripcion;
        $this->subject("Error en Preinscripci��n IESVU 9015");
        $this->archivos = $datos;
        $this->mailService = new MailService();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'tipo' => 'Error Preinscripción',
            'email' => $this->to[0]['address'],
            'archivos' => $this->archivos
        ];

        $this->mailService->store($datos);
        
        return $this->view('mail.file_error',[
            'archivos' => $this->archivos,
            'preinscripcion'    =>  $this->preinscripcion
        ]);
    }
}

