@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h5 class="text-info">
            Elige la mesa que deseas rendir
        </h5>
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
        <h5 class="text-info">
            Mesas en las que ya te has inscripto
        </h5>
        @if(count($inscripciones)>0)
            <ul class="list-group list-group-flush">
                @foreach($inscripciones as $inscripcion)
                    <li class="list-group-item">
                        <div class="card  m-0 p-0 w-100 align-self-center d-inline-block ">
                            <div class="card-body m-1 p-1" style="font-size: 0.85em">
                                <div class="row text-center m-0 p-0">
                                    <div class="col-4 m-0 p-0">
                                        @if($inscripcion->materia_id)
                                            {{ $inscripcion->materia->nombre }}
                                        @elseif($inscripcion->mesa->materia)
                                            {{$inscripcion->mesa->materia->nombre}}
                                        @else
                                            -
                                        @endif
                                    </div>
                                    <div class="col-4 m-0 p-0">
                                        {{--                                        {{ $inscripcion->materia_id ? $inscripcion->materia->nombre : $inscripcion->mesa->materia->nombre }}--}}
                                        {{ $inscripcion->instancia_id ? $inscripcion->instancia->nombre : $inscripcion->mesa->instancia->nombre}}
                                        - {{ $inscripcion->instancia_id ? $inscripcion->instancia->año : $inscripcion->mesa->instancia->año }}
                                        @if ($inscripcion->segundo_llamado)
                                            (2do llamado)
                                        @else
                                            (1er llamado)
                                        @endif

                                    </div>
                                    <div class="col-4 m-0 p-0">
                                        <div class="row">
                                            @if($inscripcion->instancia && $inscripcion->instancia->tipo == 1)
                                                @if($inscripcion->estado_baja)
                                                    <span class="text-secondary col-4 mr-1 px-0">Dada de baja</span>
                                                    <span class="text-secondary col-4 mr-1 px-0">por: {{optional($inscripcion->user()->first())->getApellidoNombre()}}</span>
                                                    <span class="text-secondary col-4 mx-0 px-0">Motivo:<br/> {{$inscripcion->motivo_baja}}</span>
                                                @else
                                                    <span class="text-secondary">Inscripto</span>
                                                    @if($inscripcion->instancia->estado == 'activa' || $inscripcion->instancia->cierre == 1)
                                                        <a href="{{route('mesa.baja',['id'=>$inscripcion->id,'instancia_id'=>$instancia->id])}}"
                                                           class="text-danger">Bajarme</a>
                                                    @endif
                                                @endif
                                            @else
                                                @if($inscripcion->estado_baja)
                                                    <span class="text-secondary col-4 mr-1 px-0">Dada de baja</span>
                                                    <span class="text-secondary col-4 mr-1 px-0">por: {{optional($inscripcion->user()->first())->getApellidoNombre()}}</span>
                                                    <span class="text-secondary col-4 mx-0 px-0">Motivo:<br/> {{$inscripcion->motivo_baja}}</span>

                                                @elseif($inscripcion->segundo_llamado && time() < $inscripcion->mesa->cierre_segundo)
                                                    -
                                                    @if($inscripcion->mesa->instancia->estado == 'activa')
                                                        <a href="{{route('mesa.baja',['id'=>$inscripcion->id,'instancia_id'=>$instancia->id])}}"
                                                           class="text-danger">Bajarme</a>
                                                    @endif
                                                @elseif(!$inscripcion->segundo_llamado && time() < $inscripcion->mesa->cierre)
                                                    -
                                                    @if($inscripcion->mesa->instancia->estado == 'activa')
                                                        <a href="{{route('mesa.baja',['id'=>$inscripcion->id,'instancia_id'=>$instancia->id])}}"
                                                           class="text-danger">Bajarme</a>
                                                    @endif
                                                @endif
                                            @endif
                                            @if($inscripcion->acta_volante()->first())
                                                <div class="sol-sm-12 col-md-6 m-0 p-0">
                                                    <h6 class="card-text font-italic">{{$inscripcion->acta_volante()->first()->updated_at->format('d-m-Y')}}</h6>
                                                </div>
                                                <div class="col-sm-12 col-md-3 m-0 p-0">
                                                    <h6 class="card-text font-italic">{{$inscripcion->acta_volante()->first()->promedio}}</h6>
                                                </div>
                                                <div class="col-sm-12 col-md-3 m-0 p-0">
{{--                                                    @if($inscripcion->segundo_llamado)--}}
{{--                                                        <h6 class="card-text font-italic">{{$inscripcion->mesa()->first()->libro_segundo}}<br/>--}}
{{--                                                             {{$inscripcion->mesa()->first()->folio_segundo}}--}}
{{--                                                        </h6>--}}
{{--                                                    @else--}}
{{--                                                        <h6 class="card-text font-italic">{{$inscripcion->mesa()->first()->libro}}<br/>--}}
{{--                                                            {{$inscripcion->mesa()->first()->folio}}--}}
{{--                                                        </h6>--}}
{{--                                                    @endif--}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No te encuentras inscripto en ninguna materia </p>
        @endif
    </div>
@endsection
