<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\AvisoRole;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AvisoController extends Controller
{

    const TIPO_ROLE = 0;
    const TIPO_VISTA = 1;

    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente');
    }

    /**
     * Display a listing of the Aviso.
     *
     * @return View
     */
    public function index()
    {
        $avisoObjects = Aviso::with('user')->orderBy('visible_hasta', 'DESC')->paginate(25);

        return view('aviso.index', compact('avisoObjects'));
    }

    /**
     * Show the form for creating a new Aviso.
     *
     * @return View
     */
    public function create()
    {
        $roles = $this->getRolPrimario();

        return view('aviso.create', compact('roles'));
    }

    /**
     * Store a new Aviso in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
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
     * @return View
     */
    public function show(int $id)
    {
        $aviso = Aviso::with('user')->findOrFail($id);

        return view('aviso.show', compact('aviso'));
    }

    /**
     * Show the form for editing the specified Aviso.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit(int $id)
    {
        $aviso = Aviso::findOrFail($id);
        $Users = User::pluck('activo', 'id')->all();
        $roles = $this->getRolPrimario();

        return view('aviso.edit', compact('aviso', 'Users', 'roles'));
    }

    /**
     * Update the specified Aviso in the storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(int $id, Request $request)
    {

        $data = $this->getDataEdit($request);
        $aviso = Aviso::findOrFail($id);

        if (!$data['visible_desde']) {
            unset($data['visible_desde']);
        } else {
            $data['visible_desde'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $data['visible_desde'])));
        }

        if (!$data['visible_hasta']) {
            unset($data['visible_hasta']);
        } else {
            $data['visible_hasta'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $data['visible_hasta'])));
        }

        $data['creador_id'] = Auth::user()->id;


        $aviso->update($data);

        AvisoRole::where(['aviso_id' => $aviso->id])->delete();


        if ($request->input('role')) {
            if (in_array('todos', $request->input('role'))) {
                $aviso->todos = true;
                $aviso->update();
            } else {
                $aviso->todos = false;
                $aviso->update();
                foreach ($request->input('role') as $role) {

                    $data_aviso['rol_id'] = $role;
                    $data_aviso['aviso_id'] = $aviso->id;
                    AvisoRole::create($data_aviso);

                }
            }
        }

        return redirect()->route('aviso.aviso.index')
            ->with('success_message', 'El aviso fue correctamente actualizado.');
    }

    /**
     * Remove the specified Aviso from the storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $aviso = Aviso::findOrFail($id);
            $aviso->delete();

            return redirect()->route('aviso.aviso.index')
                ->with('success_message', 'El aviso fue correctamente eliminado.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Se produjo un error inesperado al intentar procesar su solicitud.']);
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


    /**
     * Get the request's data from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function getDataEdit(Request $request)
    {

//        dd($request);
        $rules = [
            'mensaje' => 'required',
            'role' => 'required',
            'disabled' => 'nullable',
            'visible_desde' => 'nullable|date_format:Y-m-d\\TH:i',
            'visible_hasta' => 'nullable|date_format:Y-m-d\\TH:i',
        ];

        return $request->validate($rules);
    }

    /**
     * @return Rol[]|\LaravelIdea\Helper\App\Models\_IH_Rol_C
     */
    public function getRolPrimario()
    {
        return Rol::where([
            'tipo' => self::TIPO_ROLE
        ])->get();
    }

}
