<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Libro;

class ToolsController extends Controller
{
    public function librosSinActasVolantes()
    {
        $libros = Libro::whereDoesntHave('actasVolantes')->orderBy('numero')->orderBy('folio')->paginate(25);

        return view('admin.tools.libros_sin_actas_volantes', compact('libros'));
    }
}
