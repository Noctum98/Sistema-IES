<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatriculacionUser extends Mailable
{
    use Queueable, SerializesModels;

    public $alumno;
    public $mailService;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alumno)
    {
        $this->alumno = $alumno;
        $this->mailService = new MailService();
        $this->subject('Matriculación IESVU 9015');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'tipo' => 'Matriculación Verificada',
            'email' => $this->to[0]['address'],
            'alumno' => $this->alumno
        ];

        $this->mailService->store($datos);

        return $this->view('mail.matriculacion_user',[
            'alumno' => $this->alumno
        ]);
    }
}
