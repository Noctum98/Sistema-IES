<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Config\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuditController extends Controller
{

    public function __construct()
    {
        $this->middleware('app.roles:admin-registros');    
    }
    public function index()
    {
        $modelos = [
            'Alumnos' => 'alumnos',
            'Procesos' => 'procesos'
        ];

        return view('audit.index',['modelos' => $modelos]);
    }

    public function show($tabla)
    {
        $audits = Audit::where('table',$tabla);

        if(!Session::has('admin'))
        {
            $audits = $audits->where('changes','CREATE')->orWhere('changes','DELETE');
        }

        $audits = $audits->orderBy('updated_at','DESC')->paginate(20);

        return view('audit.show',[
            'tabla' => $tabla,
            'registros' => $audits
        ]);
    }
}
