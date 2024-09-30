<?php

namespace App\Services\Ticket;

use App\Models\Ticket\DerivacionTicket;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketEstadoTicket;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketService
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function permisosTicket($ticket)
    {
        $user = Auth::user();
        $permisos = [];
        $permisos['admin'] = false;
        $permisos['respuesta'] = false;

        if ($ticket->last_derivacion && $user->hasRole($ticket->last_derivacion->rol->nombre)) {

            if ($ticket->last_derivacion->general) {
                $permisos['admin'] = true;
            } else {
                if ($ticket->last_derivacion->carrera_id && $user->hasCarrera($ticket->last_derivacion->carrera_id)) {
                    $permisos['admin'] = true;
                }
            }
        }
        if (Session::has('admin') || Session::has('avisos')) {
            $permisos['admin'] = true;
        }

        if ($ticket->user_id == $user->id) {
            $permisos['respuesta'] = true;
        }

        if ($ticket->responsable && $ticket->responsable->user_id == $user->id) {
            $permisos['respuesta'] = true;
        }

        return $permisos;
    }

    public function cambiarEstadoticket($ticket, $from, $to)
    {
        $user_id = Auth::user()->id;
        $ticket_estado_ticket = TicketEstadoTicket::create([
            'ticket_id' => $ticket->id,
            'from_estado_ticket_id' => $from,
            'to_estado_ticket_id' => $to,
            'user_id' => $user_id
        ]);

        $ticket->last_estado_ticket_id = $ticket_estado_ticket->to_estado_ticket_id;
        $ticket->update();


        if ($ticket_estado_ticket->toEstadoTicket->identificador == 'cerrado' && $ticket->captura) {

            $ticket_delete = $this->fileService->delete('tickets', $ticket->captura);
        }

        return $ticket_estado_ticket;
    }

    public function getTickets($request, $user, $mis_roles = null, $seccion = null)
    {
        $search = $request[$seccion . '_search'];
        $categoria_id = $request[$seccion . '_categoria_id'];
        $estado_id = $request[$seccion . '_estado_id'];

        if ($seccion == 'mis_tickets') {
            $tickets = Ticket::where('user_id', auth()->id());
        }

        if ($seccion == 'asignados') {
            $tickets = Ticket::whereHas('responsable', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            });
        }

        if ($seccion == 'todos') {
            $tickets = Ticket::query();
        }

        if ($seccion == 'derivados') {
            $tickets = Ticket::whereHas('last_derivacion', function ($query) use ($mis_roles) {
                $query->whereIn('derivaciones_tickets.rol_id', $mis_roles)
                    ->where(function ($query) {
                        $query->where('derivaciones_tickets.general', true)
                            ->orWhere(function ($query) {
                                $query->where('derivaciones_tickets.general', false)
                                    ->whereIn('derivaciones_tickets.carrera_id', Auth::user()->carreras->pluck('id')->toArray());
                            });
                    });
            });
        }

        $tickets = $tickets->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('asunto', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        })
            ->when($categoria_id, function ($query, $categoria_id) {
                return $query->where('categoria_id', $categoria_id);
            });


        if ($estado_id) {
            $tickets = $tickets->where('last_estado_ticket_id', $estado_id);
        }
        $tickets = $tickets->paginate(20, ['*'], $seccion);

        return $tickets;
    }
}
