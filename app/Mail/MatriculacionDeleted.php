<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatriculacionDeleted extends Mailable
{
    use Queueable, SerializesModels;
    public $alumno;
    public $carrera;
    public $errores;
    public $motivo;
    public $mailService;

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
        $this->mailService = new MailService();
        $this->subject('Matriculación Eliminada IES 9015');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'tipo' => 'Matriculación Eliminada',
            'email' => $this->to[0]['address'],
            'motivo' => $this->motivo,
            'errores' => $this->errores
        ];

        $this->mailService->store($datos);

        return $this->view('mail.matriculacion_deleted',[
            'alumno'  => $this->alumno,
            'carrera' => $this->carrera,
            'motivo'  => $this->motivo,
            'errores' => $this->errores,
            'motivo'  => $this->motivo
        ]);
    }
}
