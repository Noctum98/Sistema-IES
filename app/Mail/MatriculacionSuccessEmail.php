<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatriculacionSuccessEmail extends Mailable
{
    use Queueable, SerializesModels;

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
        $this->subject("Matriculación IESVU 9015");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.matriculacion_success',[
            'alumno' => $this->alumno,
            'carrera' => $this->carrera,
            'url'   => $this->url
        ]);
    }
}
