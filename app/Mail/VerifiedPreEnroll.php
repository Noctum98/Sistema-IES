<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifiedPreEnroll extends Mailable
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
        $this->subject("Preinscripción Verificada");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $titulo = 'Preinscripción: '.$this->preinscripcion->nombres.' '.$this->preinscripcion->apellidos;
        $pie = 'Tu preinscripción esta completa, y tus datos han sido verificados, EL CICLO DE ACTUALIZACIÓN DE SABERES PREVIOS INICIA EL 24/10/2022, a través de nuestras aulas virtuales. 
        Antes de esa fecha recibirás un correo para ingresar al aula virtual.
        Te recomendamos leer atentamente el documento "Proceso de ingreso 2023" disponible en nuestro sitio web.';
        $subtitulo = '';
        return $this->view('mail.verified_pre_enroll',[
            'preinscripcion' => $this->preinscripcion,
            'titulo'         => $titulo,
            'subtitulo'      => $subtitulo,
            'pie'            => $pie
        ]);
    }
}
