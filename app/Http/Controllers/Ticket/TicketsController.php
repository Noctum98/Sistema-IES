<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Estados;
use App\Models\Ticket\CategoriaTicket;
use App\Models\Ticket\Estado;
use App\Models\Ticket\EstadoTicket;
use App\Models\Ticket\Ticket;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketsController extends Controller
{
    protected $fileService;
    public function __construct(
        FileService $fileService
    )
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the tickets.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tickets = Ticket::with('user', 'estado', 'ticket')->paginate(25);

        return view('tickets.tickets.index', compact('tickets'));
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
        $request['estado_id'] = $estado->id;
        $fileName = $this->fileService->store('tickets',$request['image']);
        $request['captura'] = $fileName;
        $data = $this->getData($request);

        Ticket::create($data);

        return redirect()->route('tickets.ticket.index')
            ->with('success_message', 'Ticket was successfully added.');
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
        $ticket = Ticket::with('user', 'estado')->findOrFail($id);

        return view('tickets.tickets.show', compact('ticket'));
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
        $users = User::pluck('username', 'id')->all();
        $estados = EstadoTicket::pluck('id', 'id')->all();
        $tickets = Ticket::pluck('id', 'id')->all();

        return view('tickets.tickets.edit', compact('ticket', 'users', 'estados', 'tickets'));
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

        $data = $this->getData($request);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);

        return redirect()->route('tickets.ticket.index')
            ->with('success_message', 'Ticket was successfully updated.');
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
            'estado_id' => 'required',
            'categoria_id' => 'required',
            'asunto' => 'required|string|min:1|max:191',
            'descripcion' => 'required',
            'captura' => 'required|string|min:1|max:191',
            'url' => 'string|min:1|max:191',
        ];


        $data = $request->validate($rules);




        return $data;
    }
}
