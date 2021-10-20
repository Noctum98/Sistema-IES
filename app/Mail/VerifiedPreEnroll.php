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
        return $this->view('mail.verified_pre_enroll',[
            'preinscripcion' => $this->preinscripcion
        ]);
    }
}
