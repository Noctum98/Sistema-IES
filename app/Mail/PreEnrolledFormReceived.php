<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PreEnrolledFormReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $preinscripcion;
    public $mailService;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($preinscripcion)
    {
        $this->preinscripcion = $preinscripcion;
        $this->mailService = new MailService();
        $this->subject("Preinscripción IESVU 9015");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'tipo' => 'Preinscripción',
            'email' => $this->to[0]['address']
        ];

        $this->mailService->store($datos);

        $titulo = 'Preinscripción: '.$this->preinscripcion->nombres.' '.$this->preinscripcion->apellidos;
        return $this->view('mail.pre_enrolled',[
            'preinscripcion' => $this->preinscripcion,
            'titulo'         => $titulo
        ]);
    }
}
