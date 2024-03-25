<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CondicionMateriaApiDocsApiDocsController extends Controller
{

    /**
     * Display the documentation's view.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        return view('api-docs.condicion_materias.index');
    }

}
