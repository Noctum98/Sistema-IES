<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\User;
use Illuminate\Http\Request;

class UserCarreraController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.roles:admin');
    }

    public function store(Request $request,$user_id)
    {
        $user = User::find($user_id);
        $user->carreras()->attach(Carrera::find($request['carrera_id']));

        return redirect()->route('usuarios.admin')->with(['carrera_success'=>'Se han añadido la carrera al usuario']);
    }
}
