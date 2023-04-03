<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatriculacionUser extends Mailable
{
    use Queueable, SerializesModels;

    public $alumno;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alumno)
    {
        $this->alumno = $alumno;
        $this->subject('Matriculación IESVU 9015');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.matriculacion_user',[
            'alumno' => $this->alumno
        ]);
    }
}
