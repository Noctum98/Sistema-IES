<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Repository\Library\LibraryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LibrariesAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            ['app.roles:admin-coordinador-regente-seccionAlumnos-areaSocial']

        );
    }

    /**
     * Display a listing of the libraries.
     *
     * @return View
     */
    public function index()
    {
        $libraries = Library::paginate(25);

        return view('admin.library.index', compact('libraries'));
    }

    /**
     * Show the form for creating a new library.
     *
     * @return View
     */
    public function create()
    {

        $repo = new LibraryRepository();
        $max = $repo->getLibrariesMax();
        return view('admin.library.create', ['max' => $max]);
    }

    /**
     * Store a new library in the storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $mensaje = "";
        $repo = new LibraryRepository();

        $data = $this->getData($request);
        $data['user_id'] = Auth::user()->id;

        if($data['orden']){
            $igualOrden = Library::where('orden', $data['orden'])->get();
            if (count($igualOrden) > 0) {
                $mensaje = "Ya existe una biblioteca con el mismo orden.";
                $otras = $repo->getLibrariesMayorIgualQue($data['orden']);

                foreach ($otras as $otra) {
                    $otra->orden = $otra->orden + 1;
                    $otra->save();
                }
            }
        }else{
            $max = $repo->getLibrariesMax();
            $data['orden'] = $max + 1;
        }



        Library::create($data);

        return redirect()->route('admin-libraries.library.index')
            ->with('success_message', 'Biblioteca correctamente creada. ' . $mensaje);
    }

    /**
     * Display the specified library.
     *
     * @param string $id
     *
     * @return View
     */
    public function show(string $id)
    {
        $library = Library::findOrFail($id);

        return view('libraries.show', compact('library'));
    }

    /**
     * Show the form for editing the specified library.
     *
     * @param string $id
     *
     * @return View
     */
    public function edit(string $id)
    {
        $library = Library::findOrFail($id);


        return view('admin.library.edit', compact('library'));
    }

    /**
     * Update the specified library in the storage.
     *
     * @param string $id
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(string $id, Request $request)
    {

        $data = $this->getData($request);

        $library = Library::findOrFail($id);
        $library->update($data);

        return redirect()->route('admin-libraries.library.index')
            ->with('success_message', 'Biblioteca correctamente actualizada.');
    }

    /**
     * Remove the specified library from the storage.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $library = Library::findOrFail($id);
            $library->delete();

            return redirect()->route('admin.library.index')
                ->with('success_message', 'Biblioteca correctamente eliminada.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Ha ocurrido un error al procesar su solicitud.']);
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
            'name' => 'required|string|min:1|max:191',
            'link' => 'required|string|min:1|max:191',
            'orden' => 'nullable|integer',
        ];

        return $request->validate($rules);
    }

}
