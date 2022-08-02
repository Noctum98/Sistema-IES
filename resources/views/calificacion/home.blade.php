@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h3 class="text-info">
            Planilla de Calificaciones: Elige la materia    
        </h3>
        <hr>
        @if(count($materias) > 0)
            <h5 class="text-secondary">Materias</h5>
            @foreach($materias as $materia)
                @if($materia)
                <a type="button" href="{{ route($ruta,['materia_id'=>$materia->id]) }}"
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
       
        @if(count($cargos) > 0)
        <hr>
        <h5 class="text-secondary">Cargos</h5>
            @foreach(Auth::user()->cargo_materia()->get() as $cargo_materia)
                <div class="border border-secondary border-top-0 pl-2 pt-1">
{{--                @foreach($cargo_materia->materia as $materia)--}}
{{--{{$cargo_materia->materia->nombre}} <br/>--}}
{{--                    <h5>{{$cargo->nombre.' - '. $cargo->carrera->nombre.'('.$cargo->carrera->sede->nombre.')'}}</h5>--}}
{{--                    @if(isset($materia))--}}
                    <a type="button" href="{{ route($ruta,['materia_id'=>$cargo_materia->materia->id,'cargo_id'=>$cargo_materia->cargo->id]) }}"
                       class="list-group-item list-group-item-action border-top mt-2 text-primary"
                       title="Ver calificaciones"
                    >
                        <strong>
                            {{$cargo_materia->cargo->nombre}}<br/>
                            Módulo: {{ $cargo_materia->materia->nombre.' ( '.ucwords($cargo_materia->materia->carrera->turno).' | Res: '.$cargo_materia->materia->carrera->resolucion.' )' }}
                        </strong>
                    </a>
{{--                    @endif--}}
{{--                @endforeach--}}
                </div>
            @endforeach
        @endif
    </div>
@endsection
