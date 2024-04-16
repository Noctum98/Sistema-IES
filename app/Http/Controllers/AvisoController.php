<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use App\Models\AvisoRole;
use App\Models\Rol;
use App\Models\User;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class AvisoController extends Controller
{

    const TIPO_ROLE = 0;
    const TIPO_VISTA = 1;

    /**
     * Display a listing of the Aviso.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $avisoObjects = Aviso::with('user')->orderBy('visible_hasta', 'DESC')->paginate(25);

        return view('aviso.index', compact('avisoObjects'));
    }

    /**
     * Show the form for creating a new Aviso.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Rol::where([
            'tipo' => self::TIPO_ROLE
        ])->get();

        return view('aviso.create', compact('roles'));
    }

    /**
     * Store a new Aviso in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);
        $data['visible_desde'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $data['visible_desde'])));
        $data['visible_hasta'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $data['visible_hasta'])));
        $data['creador_id'] = Auth::user()->id;


        $aviso = Aviso::create($data);


        if ($request->input('role_destinatario')) {
            foreach ($request->input('role_destinatario') as $role) {

                if ($role == 0) {
                    $aviso->todos = true;
                    $aviso->update();
                } else {
                    $data_aviso['rol_id'] = $role;
                    $data_aviso['aviso_id'] = $aviso->id;
                    AvisoRole::create($data_aviso);
                }
            }
        }


        return redirect()->route('aviso.aviso.index')
            ->with('success_message', 'Aviso fue correctamente agregado.');
    }

    /**
     * Display the specified Aviso.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $aviso = Aviso::with('user')->findOrFail($id);

        return view('aviso.show', compact('aviso'));
    }

    /**
     * Show the form for editing the specified Aviso.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $aviso = Aviso::findOrFail($id);
        $Users = User::pluck('activo', 'id')->all();

        return view('aviso.edit', compact('aviso', 'Users'));
    }

    /**
     * Update the specified Aviso in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);

        $aviso = Aviso::findOrFail($id);
        $aviso->update($data);

        return redirect()->route('aviso.aviso.index')
            ->with('success_message', 'El aviso fue correctamente actualizado.');
    }

    /**
     * Remove the specified Aviso from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $aviso = Aviso::findOrFail($id);
            $aviso->delete();

            return redirect()->route('aviso.aviso.index')
                ->with('success_message', 'El aviso fue correctamente eliminado.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function getData(Request $request)
    {

//        dd($request);
        $rules = [
            'mensaje' => 'required',
            'role_destinatario' => 'required',
            'visible_desde' => 'nullable|date_format:Y-m-d\\TH:i',
            'visible_hasta' => 'nullable|date_format:Y-m-d\\TH:i',
        ];

        return $request->validate($rules);
    }

}
