<?php

namespace App\Services\Ticket;

use App\Models\Ticket\DerivacionTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketService
{
    public function permisosTicket($ticket)
    {
        $user = Auth::user();
        $permisos = [];
        $permisos['admin'] = false;
        $permisos['respuesta'] = false;
        if($ticket->derivacion && $user->hasRole($ticket->derivacion->rol->nombre))
        {
            if($ticket->derivacion->general)
            {
                $permisos['admin'] = true;
                $permisos['respuesta'] = true;
            }else{
                if($ticket->derivacion->carrera_id && $user->hasCarrera($ticket->derivacion->carrera_id))
                {
                    $permisos['admin'] = true;
                    $permisos['respuesta'] = true;
                }
            }
        }
        if(Session::has('admin'))
        {
            $permisos['admin'] = true;
        }

        if($ticket->user_id == $user)
        {
            $permisos['respuesta'] = true;
        }

        return $permisos;
    }

}