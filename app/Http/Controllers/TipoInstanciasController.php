<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoInstancia;
use Illuminate\Http\Request;
use Exception;

class TipoInstanciasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('app.roles:admin');
    }

    /**
     * Display a listing of the tipo instancias.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tipoInstancias = TipoInstancia::paginate(25);

        return view('tipo_instancias.index', compact('tipoInstancias'));
    }

    /**
     * Show the form for creating a new tipo instancia.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('tipo_instancias.create');
    }

    /**
     * Store a new tipo instancia in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        TipoInstancia::create($data);

        return redirect()->route('tipo_instancias.tipo_instancia.index')
            ->with('success_message', 'Tipo Instancia was successfully added.');
    }

    /**
     * Display the specified tipo instancia.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $tipoInstancia = TipoInstancia::findOrFail($id);

        return view('tipo_instancias.show', compact('tipoInstancia'));
    }

    /**
     * Show the form for editing the specified tipo instancia.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tipoInstancia = TipoInstancia::findOrFail($id);
        

        return view('tipo_instancias.edit', compact('tipoInstancia'));
    }

    /**
     * Update the specified tipo instancia in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $tipoInstancia = TipoInstancia::findOrFail($id);
        $tipoInstancia->update($data);

        return redirect()->route('tipo_instancias.tipo_instancia.index')
            ->with('success_message', 'Tipo Instancia was successfully updated.');  
    }

    /**
     * Remove the specified tipo instancia from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $tipoInstancia = TipoInstancia::findOrFail($id);
            $tipoInstancia->delete();

            return redirect()->route('tipo_instancias.tipo_instancia.index')
                ->with('success_message', 'Tipo Instancia was successfully deleted.');
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
                'name' => 'string|min:1|max:255|nullable',
            'identifier' => 'string|min:1|nullable', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
