<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Ticket\EstadoTicket;
use Illuminate\Http\Request;
use Exception;

class EstadoTicketsController extends Controller
{

    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin');
    }
    
    /**
     * Display a listing of the estado tickets.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $estadoTickets = EstadoTicket::paginate(25);

        return view('tickets.estado_tickets.index', compact('estadoTickets'));
    }

    /**
     * Show the form for creating a new estado ticket.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('tickets.estado_tickets.create');
    }

    /**
     * Store a new estado ticket in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        EstadoTicket::create($data);

        return redirect()->route('estado_tickets.estado_ticket.index')
            ->with('success_message', 'Estado Ticket creado correctamente.');
    }

    /**
     * Display the specified estado ticket.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $estadoTicket = EstadoTicket::findOrFail($id);

        return view('tickets.estado_tickets.show', compact('estadoTicket'));
    }

    /**
     * Show the form for editing the specified estado ticket.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $estadoTicket = EstadoTicket::findOrFail($id);
        

        return view('tickets.estado_tickets.edit', compact('estadoTicket'));
    }

    /**
     * Update the specified estado ticket in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $estadoTicket = EstadoTicket::findOrFail($id);
        $estadoTicket->update($data);

        return redirect()->route('estado_tickets.estado_ticket.index')
            ->with('success_message', 'Estado Ticket actualizado correctamente.');  
    }

    /**
     * Remove the specified estado ticket from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $estadoTicket = EstadoTicket::findOrFail($id);
            $estadoTicket->delete();

            return redirect()->route('estado_tickets.estado_ticket.index')
                ->with('success_message', 'Estado Ticket eliminado correctamente.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'nombre' => 'required|string|min:1|max:191', 
                'identificador' => 'required|string|min:1|max:191', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
