<?php

namespace App\Http\Controllers\Parameters;

use App\Http\Controllers\Controller;
use App\Models\Parameters\Calendario;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('app.auth');
        $this->middleware('app.roles:admin-regente');
    }

    public function index(Request $request)
    {
        $fechas = Calendario::orderBy('mes')->get();

        return view('calendario.index',['fechas'=>$fechas]);
    }

    public function store(Request $request)
    {
        $request['fecha'] = $request['mes'].'-'.$request['dia'];
        $calendario = Calendario::create($request->all());


        return redirect()->back()->with(['alert_success'=>'Fecha '.$calendario->fecha.' agregada.']);
    }

    public function update(Request $request,$id)
    {
        $request['fecha'] = $request['mes'].'-'.$request['dia'];
        unset($request['_method']);
        $calendario = Calendario::find($id);
        $calendario->update($request->all());

        return redirect()->back()->with(['alert_success'=>'Fecha '.$calendario->fecha.' editada correctamente.']);

    }

    public function destroy(Request $request,$id)
    {
        $calendario = Calendario::where('id',$id)->delete();

        return redirect()->back()->with(['alert_warning'=>'Fecha eliminada correctamente.']);
    }
}

