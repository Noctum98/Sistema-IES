@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h3 class="text-info">
            Elige la materia para ver la planilla de asistencia
        </h3>
        <hr>
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
                    <a type="button" href="{{ route($ruta,['id'=>$materia->id]) }}"
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
