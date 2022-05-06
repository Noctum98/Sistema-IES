<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BajaMesaMotivos extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($motivos,$instancia,$inscripcion)
    {
        $this->motivos = $motivos;
        $this->instancia = $instancia;
        $this->inscripcion = $inscripcion;
        $this->subject('Baja en Mesas de Examenes');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.baja_mesa_motivos',[
            'motivos' => $this->motivos,
            'instancia' => $this->instancia,
            'inscripcion' => $this->inscripcion
        ]);
    }
}
