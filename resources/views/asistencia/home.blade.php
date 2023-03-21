@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
        <h4 class="text-info">
            Elige la materia para ver la planilla de asistencia
            <br/> <small class="text-dark">Ciclo lectivo: <b>{{$ciclo_lectivo}}</b></small>
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

                            <li>
                                <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                   href="{{route('asis.inicio', ['ciclo_lectivo'=> $i])}}">{{$i}}</a>
                            </li>


                        @endfor
                    </ul>
                </div>
            </div>
        </div>

        @if(count($materias) > 0)
            <h4 class="text-secondary">Materias</h4>
            @foreach($materias as $materia)
                @if($materia->getTotalAttribute() > 0)
                    <a type="button"
                    class="list-group-item list-group-item-action border-top mt-2 text-success" data-bs-toggle="modal" data-bs-target="#eligeComision{{$materia->id}}">
                        <strong>
                            {{ $materia->carrera->sede->nombre.': '.$materia->carrera->nombre.' - '.$materia->nombre.' ( '.ucwords($materia->carrera->turno).' | Res: '.$materia->carrera->resolucion.' )' }}
                        </strong>
                    </a>
                    @include('asistencia.modals.comisiones')
                @else
                    <a type="button" href="{{ route($ruta,['id'=>$materia->id, 'ciclo_lectivo' => $ciclo_lectivo] ) }}"
                    class="list-group-item list-group-item-action border-top mt-2 text-success">
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
            @include('asistencia.componentes.materia')
            @endif
            @if(count(Auth::user()->cargo_materia()->get()) > 0)
                @include('asistencia.componentes.cargo_materia')
            @endif
{{--            @foreach(Auth::user()->cargo_materia()->get() as $cargo_materia)--}}
{{--                @foreach($cargo->materias as $materia)--}}
{{--                <h5>{{$cargo->nombre.' - '. $cargo->carrera->nombre.'('.$cargo->carrera->sede->nombre.')'}}</h5>--}}
{{--                    <a type="button" href="{{ route($ruta,['id'=>$cargo_materia->materia->id,'cargo_id'=>$cargo_materia->cargo->id]) }}"--}}
{{--                       class="list-group-item list-group-item-action border-top mt-2 text-success">--}}
{{--                        <strong>--}}
{{--                            {{$cargo_materia->cargo->nombre}}<br/>--}}
{{--                            Módulo: {{ $cargo_materia->materia->nombre.' ( '.ucwords($cargo_materia->materia->carrera->turno).' | Res: '.$cargo_materia->materia->carrera->resolucion.' )' }}--}}
{{--                        </strong>--}}
{{--                    </a>--}}
{{--                @endforeach--}}

{{--            @endforeach--}}
    </div>
@endsection
