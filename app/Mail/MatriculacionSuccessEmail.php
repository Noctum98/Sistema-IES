<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatriculacionSuccessEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $alumno;
    public $carrera;
    public $url;
    public $mailService;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alumno,$carrera)
    {
        $this->alumno = $alumno;
        $this->carrera = $carrera;
        $this->url = config('app.APP_URL');
        $this->mailService = new MailService();
        $this->subject("Matriculación IESVU 9015");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'tipo' => 'Matriculación Enviada',
            'email' => $this->to[0]['address']
        ];

        $this->mailService->store($datos);

        return $this->view('mail.matriculacion_success',[
            'alumno' => $this->alumno,
            'carrera' => $this->carrera,
            'url'   => $this->url
        ]);
    }
}
