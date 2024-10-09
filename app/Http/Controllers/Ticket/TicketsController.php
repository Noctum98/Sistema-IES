<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Estados;
use App\Models\Rol;
use App\Models\Sede;
use App\Models\Ticket\CategoriaTicket;
use App\Models\Ticket\Estado;
use App\Models\Ticket\EstadoTicket;
use App\Models\Ticket\Ticket;
use App\Models\User;
use App\Services\FileService;
use App\Services\Ticket\TicketService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketsController extends Controller
{
    protected $fileService;
    protected $ticketService;

    public function __construct(
        FileService $fileService,
        TicketService $ticketService
    )
    {
        $this->fileService = $fileService;
        $this->ticketService = $ticketService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the tickets.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $mis_roles = Auth::user()->roles->pluck('id');
        $mensajes = [
            'mis_tickets' => 'Se visualizan los tickets que he creado.',
            'derivados' => 'Se visualizan los tickets que corresponden a mi sección o al rol que desempeño.',
            'asignados' => 'Se visualizan los tickets que me asignan, o los que me asigno para resolver.',
            'todos' => 'Se visualizan todos los tickets creados, asignados y derivados.'
        ];

        $misTickets = $this->ticketService->getTickets($request,$user,$mis_roles,'mis_tickets');
        $derivados = $this->ticketService->getTickets($request,$user,$mis_roles,'derivados');
        $asignados = $this->ticketService->getTickets($request,$user,$mis_roles,'asignados');
        $todos = $this->ticketService->getTickets($request,$user,$mis_roles,'todos');
        $estados = EstadoTicket::all();
        $categorias = CategoriaTicket::all();
        return view('tickets.tickets.index', compact('misTickets','asignados','derivados','estados','categorias','todos','request','mensajes'));
    }

    /**
     * Show the form for creating a new ticket.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::pluck('username', 'id')->all();
        $estados = EstadoTicket::select('id','nombre')->get();
        $categorias = CategoriaTicket::pluck('nombre','id')->all();

        return view('tickets.tickets.create', compact('users', 'estados','categorias'));
    }

    /**
     * Store a new ticket in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $estado = EstadoTicket::where('identificador','abierto')->first();
        $request['user_id'] = Auth::user()->id;


        $data = $this->getData($request);

        if($request['image'])
        {
            $fileName = $this->fileService->store('tickets',$request['image']);
            $data['captura'] = $fileName;
        }
        $ticket = Ticket::updateOrCreate($data);
        $this->ticketService->cambiarEstadoticket($ticket,$estado->id,$estado->id);

        
  

        return redirect()->route('tickets.ticket.index')
            ->with('success_message', 'Ticket creado correctamente.');
    }

    /**
     * Display the specified ticket.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $estados = EstadoTicket::pluck('nombre', 'id')->all();
        $roles = Rol::where('tipo',0)->pluck('descripcion','id')->all();
        $sedes = Sede::pluck('nombre','id')->all();
        $rol = $ticket->last_derivacion ? $ticket->last_derivacion->rol_id : null;
        $users = null;

        if($rol)
        {
            $users = User::whereHas('roles',function($query) use ($rol){
                return $query->where('roles.id',$rol);
            })->get();
        }

        $permisos = $this->ticketService->permisosTicket($ticket);
        $admin = $permisos['admin'];
        $respuesta = $permisos['respuesta'];

        return view('tickets.tickets.show', compact('ticket','estados','roles','sedes','admin','respuesta','users'));
    }

    /**
     * Show the form for editing the specified ticket.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $estados = EstadoTicket::pluck('id', 'id')->all();
        $categorias = CategoriaTicket::pluck('nombre','id')->all();

        return view('tickets.tickets.edit', compact('ticket',  'estados', 'categorias'));
    }

    /**
     * Update the specified ticket in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());

        return redirect()->route('tickets.ticket.index')
            ->with('success_message', 'Ticket actualizado correctamente.');
    }

    /**
     * Remove the specified ticket from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $this->fileService->delete('tickets',$ticket->captura);
            $ticket->delete();

            return redirect()->route('tickets.ticket.index')
                ->with('success_message', 'Ticket was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    public function showCaptura(Request $request, $ticket_id)
    {
        $ticket = Ticket::select('captura')->where('id',$ticket_id)->first();
        $rutaArchivo = 'tickets/' . $ticket->captura;

        $rutaCompleta = storage_path("app/{$rutaArchivo}");

        $mimeType = mime_content_type($rutaCompleta);

        if (Storage::disk('local')->exists($rutaArchivo)) {
            $headers = [
                'Content-Type' => $mimeType,
            ];

            return response()->file($rutaCompleta, $headers);
        } else {
            abort(404, 'Archivo no encontrado');
        }
    }

    public function changeEstado(Request $request,$ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);

        $ticket_estado_ticket = $this->ticketService->cambiarEstadoticket($ticket,$ticket->last_estado_ticket->id,$request['estado_id']);

        return redirect()->back()->with(['alert_success'=>'Estado del ticket actualizado.']);
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
            'user_id' => 'required',
            'categoria_id' => 'required',
            'asunto' => 'required|string|min:1|max:191',
            'descripcion' => 'required',
            'captura' => 'file|mimes:jpg,jpeg,png,pdf|max:5000',
            'url' => 'nullable|string'
        ];


        $data = $request->validate($rules);




        return $data;
    }
}
