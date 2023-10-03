<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BajaMesaMotivos extends Mailable
{
    use Queueable, SerializesModels;

    public $motivos;
    public $instancia;
    public $inscripcion;
    public $mailService;

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
        $this->mailService = new MailService();
        $this->subject('Baja en Mesas de Examenes');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'tipo' => 'Baja Mesas',
            'email' => $this->to[0]['address'],
            'instancia' => $this->instancia,
            'inscripcion' => $this->inscripcion
        ];

        $this->mailService->store($datos);

        return $this->view('mail.baja_mesa_motivos',[
            'motivos' => $this->motivos,
            'instancia' => $this->instancia,
            'inscripcion' => $this->inscripcion
        ]);
    }
}
