<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifiedPreEnroll extends Mailable
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
        $this->subject("Preinscripción Verificada");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'tipo' => 'Preinscripción Verificada',
            'email' => $this->to[0]['address']
        ];

        $this->mailService->store($datos);

        $titulo = 'Preinscripción: '.$this->preinscripcion->nombres.' '.$this->preinscripcion->apellidos;
        $pie = 'Tu preinscripción esta completa, y tus datos han sido verificados.';
        $subtitulo = '';
        return $this->view('mail.verified_pre_enroll',[
            'preinscripcion' => $this->preinscripcion,
            'titulo'         => $titulo,
            'subtitulo'      => $subtitulo,
            'pie'            => $pie
        ]);
    }
}
