<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Ticket\AsignacionTicket;
use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsignacionTicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['asignante_id'] = Auth::user()->id;
        $ticket = Ticket::find($request['ticket_id']);
        $data = $this->getData($request);

        if($ticket->responsable && $ticket->responsable->user->id == $request['user_id'])
        {
            return redirect()->back()->with(['alert_danger'=>'El usuario indicado ya es el reponsable del ticket.']);
        }

        $responsables = AsignacionTicket::where('ticket_id',$data['ticket_id'])->update(['responsable'=>false]);

        $data['responsable'] = true;

        $asignacionTicket = AsignacionTicket::create($data);

        return redirect()->back()->with(['alert_success'=>'Has tomado el ticket correctamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $asignacionesTicket = AsignacionTicket::where('ticket_id',$ticket_id)->with(['user','derivacion','ticket','asignante'])->get();

        return response()->json($asignacionesTicket,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getData(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'derivacion_id' => 'required',
            'ticket_id' => 'required',
            'asignante_id' => 'required'
        ];

        $data = $request->validate($rules);

        return $data;
    }
}
