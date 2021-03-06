<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatriculacionDeleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alumno,$carrera,$request)
    {
        $this->alumno = $alumno;
        $this->carrera = $carrera;
        $this->errores = $request['errores'];
        $this->motivo = $request['motivo'];
        $this->subject('Matriculación Eliminada IES 9015');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.matriculacion_deleted',[
            'alumno'  => $this->alumno,
            'carrera' => $this->carrera,
            'motivo'  => $this->motivo,
            'errores' => $this->errores,
            'motivo'  => $this->motivo
        ]);
    }
}
