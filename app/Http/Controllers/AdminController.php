<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('app.roles:admin-regente');
    }

    public function vista_calificaciones(Request $request)
    {
        if($request->get('orden')){

               $carreras = Carrera::all()->sortBy($request->get('orden'),1);

        }else{
            $carreras = Carrera::all();
        }


        return view('admin.calificaciones.list', [
            'carreras'  => $carreras
        ]);
    }
}
