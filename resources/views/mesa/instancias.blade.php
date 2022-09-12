@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h4 class="text-info">
            Elige la mesa que deseas rendir
        </h4>
        <hr>

        @if(count($instancias) > 0)
            @foreach($instancias as $instancia)

                <a type="button" href="{{ route('mesa.mate',$instancia->id) }}"
                   class="list-group-item list-group-item-action border-top mt-2 text-primary p-3">
                    <strong>
                        {{ $instancia->nombre }}
                    </strong>
                </a>
            @endforeach
        @else
            <h3 class="text-secondary">No hay mesas abiertas</h3>
        @endif
        <hr>
        <h4 class="text-info">
            Mesas en las que ya te has inscripto
        </h4>
        @if(count($inscripciones)>0)
            <ul class="list-group list-group-flush">
                @foreach($inscripciones as $inscripcion)
                    <li class="list-group-item">
                        {{ $inscripcion->materia_id ? $inscripcion->materia->nombre : $inscripcion->mesa->materia->nombre }}
                        - {{ $inscripcion->instancia_id ? $inscripcion->instancia->nombre : $inscripcion->mesa->instancia->nombre}}
                        - {{ $inscripcion->instancia_id ? $inscripcion->instancia->año : $inscripcion->mesa->instancia->año }}
                        @if($inscripcion->instancia && $inscripcion->instancia->tipo == 1)
                            @if($inscripcion->estado_baja)
                                <span class="text-secondary">Dada de baja</span>
                            @else
                                <span class="text-secondary">Se presenta</span>
                                @if($inscripcion->instancia->estado == 'activa')
                                    <a href="{{route('mesa.baja',['id'=>$inscripcion->id,'instancia_id'=>$instancia->id])}}"
                                       class="text-danger">Bajarme</a>
                                @endif
                            @endif
                        @else
                            @if(!$inscripcion->segundo_llamado)
                                <span class="font-weight-bold">1er llamado </span>
                            @else
                                <span class="font-weight-bold">2do llamado </span>
                            @endif

                            @if($inscripcion->estado_baja)
                                <span class="text-secondary">Dada de baja</span>

                            @elseif($inscripcion->segundo_llamado && time() < $inscripcion->mesa->cierre_segundo)
                                -
                                @if($inscripcion->mesa->instancia->estado == 'activa')
                                    <a href="{{route('mesa.baja',['id'=>$inscripcion->id,'instancia_id'=>$instancia->id])}}"
                                       class="text-danger">Bajarme</a>
                                @endif
                            @elseif(!$inscripcion->segundo_llamado && time() < $inscripcion->mesacierre)
                                -
                                @if($inscripcion->mesa->instancia->estado == 'activa')
                                    <a href="{{route('mesa.baja',['id'=>$inscripcion->id,'instancia_id'=>$instancia->id])}}"
                                       class="text-danger">Bajarme</a>
                                @endif

                            @endif
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>No te encuentras inscripto en ninguna materia </p>
        @endif

    </div>
@endsection
