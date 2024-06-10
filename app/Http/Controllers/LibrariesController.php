<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\View\View;

class LibrariesController extends Controller
{

    /**
     * Display a listing of the libraries.
     *
     * @return View
     */
    public function index()
    {
        $libraries = Library::orderBy('orden')->paginate(25);

        return view('libraries.index', compact('libraries'));
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


}
