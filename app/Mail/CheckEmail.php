<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckEmail extends Mailable
{
    use Queueable, SerializesModels;

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
        $this->subject("Verificar email IESVU 9015");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.check_mail',[
            'timecheck' => $this->mail_check->timecheck,
            'carrera_id' => $this->carrera_id,
            'año'   => $this->año
        ]);
    }
}
