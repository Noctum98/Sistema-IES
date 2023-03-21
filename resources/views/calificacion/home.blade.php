@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h4 class="text-info">
                    Planilla de Calificaciones<br/>
                    <small>Por favor seleccione materia/cargo {{$ciclo_lectivo}}</small>

                </h4>
            </div>
            <div class="col-4">
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1"
                            data-bs-toggle="dropdown">
                        Ciclo lectivo
                    </button>
                    <ul class="dropdown-menu">
                        @for ($i = $changeCicloLectivo[1]; $i >= $changeCicloLectivo[0]; $i--)

                            <li>  <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif " href="{{route('calificacion.home', ['ciclo_lectivo'=> $i])}}">{{$i}}</a></li>

                            </li>
                        @endfor
                    </ul>
                </div>
            </div>


        </div>
        <hr>
        @if(count($materias) > 0)
            <h5 class="text-secondary">Materias</h5>
            @foreach($materias as $materia)
                @if($materia)
                    <a type="button" href="{{ route($ruta,['materia_id'=>$materia->id, 'ciclo_lectivo' => $ciclo_lectivo]) }}"
                       class="list-group-item list-group-item-action border-top mt-2 text-primary"
                       title="Ver calificaciones"
                    >
                        <strong>
                            {{ $materia->carrera->sede->nombre.': '.$materia->carrera->nombre.' - '.$materia->nombre.' ( '.ucwords($materia->carrera->turno).' | Res: '.$materia->carrera->resolucion.' )' }}
                        </strong>
                    </a>
                @endif
            @endforeach
        @endif

       
            <hr>
            <h5 class="text-secondary">Cargos</h5>
            @if(count($cargos) > 0)
            @include('calificacion.componentes.materia')
            @endif
            @if(count(Auth::user()->cargo_materia()->get()) > 0)
                @include('calificacion.componentes.cargo_materia')
            @endif
        
    </div>

@endsection
