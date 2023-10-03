<?php

namespace App\Mail;

use App\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $mail_check;
    public $carrera_id;
    public $año;
    public $mailService;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_check,$carrera_id,$año)
    {
        $this->mail_check = $mail_check;
        $this->carrera_id = $carrera_id;
        $this->año = $año; 
        $this->mailService = new MailService();
        $this->subject("Verificar email IESVU 9015");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datos = [
            'tipo' => 'Check Email',
            'email' => $this->to[0]['address']
        ];

        $this->mailService->store($datos);

        return $this->view('mail.check_mail',[
            'timecheck' => $this->mail_check->timecheck,
            'carrera_id' => $this->carrera_id,
            'año'   => $this->año
        ]);
    }
}
