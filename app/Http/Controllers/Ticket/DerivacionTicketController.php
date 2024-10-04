<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Ticket\AsignacionTicket;
use App\Models\Ticket\DerivacionTicket;
use Illuminate\Http\Request;

class DerivacionTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request,$ticket_id)
    {
        $derivaciones = DerivacionTicket::where('ticket_id',$ticket_id)->with(['operador','rol','ticket','sede','carrera','asignaciones','asignaciones.user','asignaciones.asignante'])->orderBy('activa','desc')->get();

        return response()->json($derivaciones,200);
    }

    public function store(Request $request)
    {
        $data = $this->getData($request);
        
        $derivacionAnterior = DerivacionTicket::where('ticket_id',$data['ticket_id'])->update(['activa'=>false]);
        $responsables = AsignacionTicket::where('ticket_id',$data['ticket_id'])->update(['responsable'=>false]);
        $derivacionTicket = DerivacionTicket::create($data);

        return redirect()->back()->with(['alert_success'=>'Se ha derivado el ticket correctamente.']);
    }

    protected function getData(Request $request)
    {
        $rules = [
            'operador_id' => 'required',
            'ticket_id' => 'required',
            'rol_id' => 'required',
            'general' => 'boolean'
        ];

        if(!$request['general'])
        {
            $rules['sede_id'] = 'required';
            $rules['carrera_id'] = 'required';
        }

        $data = $request->validate($rules);

        return $data;
    }
}
