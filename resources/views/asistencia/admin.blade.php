@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h4 class="text-info">
                    Asistencias {{ $materia->nombre }}
                    @if($cargo??'')
                        <br/>
                        <h5 class="text-dark ml-2 d-inline-block">Cargo: <i>{{$cargo->nombre}}</i></h5>
                        <a href="{{route('proceso.listadoCargo', ['materia_id' => $materia->id, 'cargo_id'=> $cargo->id])}}"
                           class="btn btn-sm d-inline-block"
                        >
                            <i class="fa fa-external-link-alt"></i> Ver calificaciones
                        </a>
                    @endif
                </h4>

            </div>
            <div class="col-4">
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1"
                            data-bs-toggle="dropdown">
                        Ciclo lectivo <small>{{$ciclo_lectivo}}</small>
                    </button>
                    <ul class="dropdown-menu">
                        @for ($i = $changeCicloLectivo[1]; $i >= $changeCicloLectivo[0]; $i--)

                            <li>
                                <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                   @if($cargo??'')
                                       href="{{route('asis.admin', ['id'=>$materia->id,'ciclo_lectivo' => $i,'cargo_id'=>$cargo->id]) }}">{{$i}}

                                    @else
                                        href="{{route('asis.admin', ['id'=>$materia->id, 'ciclo_lectivo' => $i] ) }}">{{$i}}
                                    @endif
                                </a>


                            </li>

                        @endfor
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <br>
            @if($materia->carrera->tipo == 'tradicional')
                @include('asistencia.tables.table_tradicional')
            @elseif($materia->carrera->tipo == 'tradicional2')
                @include('asistencia.tables.table_tradicional_7030')
            @elseif($materia->carrera->tipo == 'modular')
                @include('asistencia.tables.table_modular')
            @elseif($materia->carrera->tipo == 'modular2')
                @include('asistencia.tables.table_modular_7030')
            @endif

        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/asistencia/create.js') }}"></script>
@endsection
