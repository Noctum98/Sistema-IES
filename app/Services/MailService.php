<?php

namespace App\Services;

use App\Models\MailCheck;

class MailService
{
    public function checkEmail($timecheck)
    {
        $mailCheck = MailCheck::where('timecheck',$timecheck)->first();

        $mailCheck->checked = true;

        $mailCheck->update();

        return $mailCheck;
    }
}