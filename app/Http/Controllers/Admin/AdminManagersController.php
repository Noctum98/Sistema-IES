<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AdminManagersController extends Controller
{

    /**
     * Display a listing of the admin managers.
     *
     * @return View
     */
    public function index()
    {
        $adminManagers = AdminManager::orderBy('name')->paginate(25);

        return view('admin.admin_managers.index', compact('adminManagers'));
    }

    public function listado()
    {
        $adminManagers = AdminManager::orderBy('name')->paginate(25);

        return view('admin.admin_managers.listado', compact('adminManagers'));
    }

    /**
     * Show the form for creating a new admin manager.
     *
     * @return View
     */
    public function create()
    {


        return view('admin.admin_managers.create');
    }

    /**
     * Store a new admin manager in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        AdminManager::create($data);

        return redirect()->route('admin_managers.admin_manager.index')
            ->with('success_message', 'Admin Manager fue creado correctamente.');
    }

    /**
     * Display the specified admin manager.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $adminManager = AdminManager::findOrFail($id);

        return view('admin.admin_managers.show', compact('adminManager'));
    }

    /**
     * Show the form for editing the specified admin manager.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $adminManager = AdminManager::findOrFail($id);


        return view('admin.admin_managers.edit', compact('adminManager'));
    }

    /**
     * Update the specified admin manager in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $adminManager = AdminManager::findOrFail($id);
        $adminManager->update($data);

        return redirect()->route('admin_managers.admin_manager.index')
            ->with('success_message', 'Admin Manager fue actualizado correctamente.');
    }

    /**
     * Remove the specified admin manager from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $adminManager = AdminManager::findOrFail($id);
            $adminManager->delete();

            return redirect()->route('admin_managers.admin_manager.index')
                ->with('success_message', 'Admin Manager fue eliminado correctamente.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ha ocurrido un error inesperado al procesar esta solicitud.']);
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
        $rules = [
            'enabled' => 'boolean',
            'icon' => 'required|string|min:1|max:191',
            'link' => 'required|string|min:1|max:191',
            'model' => 'required|string|min:1|max:191',
            'name' => 'required|string|min:1|max:191',
        ];

        $data = $request->validate($rules);

        $data['enabled'] = $request->has('enabled');

        return $data;
    }

}
