@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1 text-info">
            Planilla de Calificaciones: Elige la materia    
        </h2>
        <hr>
        @if(count($materias) > 0)
            <h4 class="text-secondary">Materias</h4>
            @foreach($materias as $materia)
                @if($materia)
                <a type="button" href="{{ route($ruta,['materia_id'=>$materia->id]) }}"
                   class="list-group-item list-group-item-action border-top mt-2 text-primary">
                    <strong>
                        {{ $materia->carrera->sede->nombre.': '.$materia->carrera->nombre.' - '.$materia->nombre.' ( '.ucwords($materia->carrera->turno).' | Res: '.$materia->carrera->resolucion.' )' }}
                    </strong>
                </a>
                @endif
            @endforeach
        @endif
       
        @if(count($cargos) > 0)
        <hr>
        <h4 class="text-secondary">Módulos</h4>
            @foreach($cargos as $cargo)  
                @foreach($cargo->materias as $materia)

                    <h5>{{$cargo->nombre.' - '. $cargo->carrera->nombre.'('.$cargo->carrera->sede->nombre.')'}}</h5>
                    @if(isset($materia))
                    <a type="button" href="{{ route($ruta,['materia_id'=>$materia->id,'cargo_id'=>$cargo->id]) }}"

                       class="list-group-item list-group-item-action border-top mt-2 text-primary">
                        <strong>
                            {{ $materia->nombre.' ( '.ucwords($materia->carrera->turno).' | Res: '.$materia->carrera->resolucion.' )' }}
                        </strong>
                    </a>
                    @endif
                @endforeach

            @endforeach
        @endif
    </div>
@endsection
