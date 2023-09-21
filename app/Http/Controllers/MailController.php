<?php

namespace App\Http\Controllers;

use App\Mail\CheckEmail;
use App\Models\MailCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function __construct()
    {
        
    }

    public function emailPreinscripciones(Request $request,$carrera_id)
    {
        $validate = $this->validate($request,[
            'email' => ['required','email']
        ]);

        $mailCheck = MailCheck::where('email',$request['email'])->first();

        if($mailCheck && $mailCheck->checked)
        {
            return redirect()->route('alumno.pre',[
                'id' => $carrera_id,
                'timecheck' => $mailCheck->timecheck
            ]);
        }elseif ($mailCheck && !$mailCheck->checked) {
            // Mail::to($request['email'])->send(new CheckEmail($mailCheck, $carrera_id, null));
        } else {
            $parts = explode("@", $request['email']);
            $request['timecheck'] = time().$parts[0];
            $mailCheck = MailCheck::create($request->all());

            // Mail::to($request['email'])->send(new CheckEmail($mailCheck, $carrera_id, null));
        }

        return view('matriculacion.card_email_check');
    }
}
