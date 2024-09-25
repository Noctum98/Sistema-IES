<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\CategoriasTickets;
use App\Models\Ticket\CategoriaTicket;
use Illuminate\Http\Request;
use Exception;

class CategoriasTicketsController extends Controller
{

    /**
     * Display a listing of the categorias tickets.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categoriasTicketsObjects = CategoriaTicket::paginate(25);

        return view('tickets.categorias_tickets.index', compact('categoriasTicketsObjects'));
    }

    /**
     * Show the form for creating a new categorias tickets.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('tickets.categorias_tickets.create');
    }

    /**
     * Store a new categorias tickets in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        CategoriaTicket::create($data);

        return redirect()->route('categorias_tickets.categorias_tickets.index')
            ->with('success_message', 'Categorias Tickets was successfully added.');
    }

    /**
     * Display the specified categorias tickets.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $categoriasTickets = CategoriaTicket::findOrFail($id);

        return view('tickets.categorias_tickets.show', compact('categoriasTickets'));
    }

    /**
     * Show the form for editing the specified categorias tickets.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $categoriasTickets = CategoriaTicket::findOrFail($id);
        

        return view('tickets.categorias_tickets.edit', compact('categoriasTickets'));
    }

    /**
     * Update the specified categorias tickets in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $categoriasTickets = CategoriaTicket::findOrFail($id);
        $categoriasTickets->update($data);

        return redirect()->route('categorias_tickets.categorias_tickets.index')
            ->with('success_message', 'Categorias Tickets was successfully updated.');  
    }

    /**
     * Remove the specified categorias tickets from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $categoriasTickets = CategoriaTicket::findOrFail($id);
            $categoriasTickets->delete();

            return redirect()->route('categorias_tickets.categorias_tickets.index')
                ->with('success_message', 'Categorias Tickets was successfully deleted.');
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
            'horas_de_espera' => 'required|numeric|min:-2147483648|max:2147483647', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
