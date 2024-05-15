<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Resoluciones;
use App\Models\TipoCarrera;
use Illuminate\Http\Request;
use Exception;

class ResolucionesController extends Controller
{

    /**
     * Display a listing of the resoluciones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $resolucionesObjects = Resoluciones::with('tipocarrera','estado')->paginate(25);

        return view('resoluciones.index', compact('resolucionesObjects'));
    }

    /**
     * Show the form for creating a new resoluciones.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $TipoCarreras = TipoCarrera::pluck('name','id')->all();
$estados = Estado::pluck('id','id')->all();
        
        return view('resoluciones.create', compact('TipoCarreras','estados'));
    }

    /**
     * Store a new resoluciones in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        Resoluciones::create($data);

        return redirect()->route('resoluciones.resoluciones.index')
            ->with('success_message', 'Resoluciones was successfully added.');
    }

    /**
     * Display the specified resoluciones.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $resoluciones = Resoluciones::with('tipocarrera','estado')->findOrFail($id);

        return view('resoluciones.show', compact('resoluciones'));
    }

    /**
     * Show the form for editing the specified resoluciones.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $resoluciones = Resoluciones::findOrFail($id);
        $TipoCarreras = TipoCarrera::pluck('name','id')->all();
$estados = Estado::pluck('id','id')->all();

        return view('resoluciones.edit', compact('resoluciones','TipoCarreras','estados'));
    }

    /**
     * Update the specified resoluciones in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $resoluciones = Resoluciones::findOrFail($id);
        $resoluciones->update($data);

        return redirect()->route('resoluciones.resoluciones.index')
            ->with('success_message', 'Resoluciones was successfully updated.');  
    }

    /**
     * Remove the specified resoluciones from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $resoluciones = Resoluciones::findOrFail($id);
            $resoluciones->delete();

            return redirect()->route('resoluciones.resoluciones.index')
                ->with('success_message', 'Resoluciones was successfully deleted.');
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
                'name' => 'required|string|min:1|max:191',
            'title' => 'required|string|min:1|max:191',
            'duration' => 'required|numeric|min:0|max:4294967295',
            'resolution' => 'required|string|min:1|max:191',
            'type' => 'required|string|min:1|max:191',
            'vaccines' => 'required|string|min:1|max:191',
            'tipo_carrera_id' => 'required',
            'estados_id' => 'required', 
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
