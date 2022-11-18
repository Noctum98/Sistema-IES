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
