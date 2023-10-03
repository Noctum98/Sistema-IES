<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MesaUnsubscribe extends Mailable
{
    use Queueable, SerializesModels;

    public $inscripcion;
    public $instancia;
    public $mailService;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inscripcion,$instancia)
    {
        $this->inscripcion = $inscripcion;
        $this->instancia = $instancia;
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
            'tipo' => 'Baja Mesas Alumno',
            'email' => $this->to[0]['address'],
            'instancia' => $this->instancia,
            'materia' => $this->instancia->tipo == 0 ? $this->inscripcion->mesa->materia : $this->inscripcion->materia
        ];

        $this->mailService->store($datos);

        return $this->view('mail.mesa_unsubscribe',[
            'inscripcion' => $this->inscripcion,
            'instancia'   => $this->instancia
        ]);
    }
}
