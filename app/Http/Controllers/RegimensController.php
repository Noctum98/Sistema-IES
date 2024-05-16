<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Regimen;
use Illuminate\Http\Request;
use Exception;

class RegimensController extends Controller
{

    /**
     * Display a listing of the regimens.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $regimens = Regimen::paginate(25);

        return view('regimens.index', compact('regimens'));
    }

    /**
     * Show the form for creating a new regimen.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        return view('regimens.create');
    }

    /**
     * Store a new regimen in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        Regimen::create($data);

        return redirect()->route('regimens.regimen.index')
            ->with('success_message', 'Régimen fue agregado exitosamente.');
    }

    /**
     * Display the specified regimen.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $regimen = Regimen::findOrFail($id);

        return view('regimens.show', compact('regimen'));
    }

    /**
     * Show the form for editing the specified regimen.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $regimen = Regimen::findOrFail($id);


        return view('regimens.edit', compact('regimen'));
    }

    /**
     * Update the specified regimen in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);

        $regimen = Regimen::findOrFail($id);
        $regimen->update($data);

        return redirect()->route('regimens.regimen.index')
            ->with('success_message', 'Regimen fue actualizado exitosamente.');
    }

    /**
     * Remove the specified regimen from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $regimen = Regimen::findOrFail($id);
            $regimen->delete();

            return redirect()->route('regimens.regimen.index')
                ->with('success_message', 'Regimen was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Se produjo un error inesperado al intentar procesar su solicitud.']);
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
            'identifier' => 'required|string|min:1|max:191',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
