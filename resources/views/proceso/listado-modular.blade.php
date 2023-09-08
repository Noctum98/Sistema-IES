@extends('layouts.app-prueba')
@section('content')
    <style>
        thead th {
            position: sticky;
            z-index: 1;
            top: 0;
        }

        .thead-dark th {
            color: white;
            background-color: #343a40;
            border-color: rgba(52, 58, 64, 0.75);
        }

    </style>
    <div class="container" id="container-scroll">

        <div class="d-flex justify-content-between">
            <div>
                <a href="{{url()->previous()}}">
                    <button class="btn btn-sm btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
                </a>
            </div>
            <div>
                <p class="text-dark fw-bold">Notas de proceso cargo</p>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1"
                            data-bs-toggle="dropdown">
                        Ciclo lectivo {{$ciclo_lectivo}}
                    </button>
                    <ul class="dropdown-menu">
                        @for ($i = $changeCicloLectivo[1]; $i >= $changeCicloLectivo[0]; $i--)
                            <li>
                                @if($comision)
                                    <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                       href="{{ route('proceso.listadoCargo', ['materia_id'=> $materia->id, 'cargo_id' => $cargo->id,'ciclo_lectivo' => $i ,'comision_id' => $comision->id]) }}">
                                        {{$i}}
                                    </a>
                                @else
                                    <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                       href="{{ route('proceso.listadoCargo', ['materia_id'=> $materia->id, 'cargo_id' => $cargo->id,'ciclo_lectivo' => $i ]) }}">
                                        {{$i}}
                                    </a>
                                @endif
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
        <div class="row-cols-1">
            <div class="card w-75 mx-auto">
                <div class="card-header text-center text-primary">
                    <div class="card-title">
                        {{ $cargo->nombre }} @if($comision)
                            <br/><small>{{$comision->nombre}}</small>
                        @endif
                    </div>
                    <div class="card-subtitle">
                        Correspondiente al módulo <i>{{$materia->nombre}}</i> <br/>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="blockquote blockquote-footer mt-1 mb-0">Prof.: {{$cargo->profesores()}}</div>
                </div>
            </div>
        </div>

        <div id="alerts">

        </div>
        <div class="d-flex alert alert-info w-75 mx-auto">
            <div class="me-auto">
                <span><strong><i>Importante:</i></strong></span>
            </div>
            <div>
                <small><i>Después de la letra R se muestra la nota del recuperatorio, solo en el caso de los Parciales.</i></small><br/>
                <small><i>Al hacer clic en el nombre de la calificación, redirige a la misma.</i></small>
            </div>
        </div>


        {{-- @if($comision)
            <!-----<a href="{{ route('excel.procesos',['materia_id'=>$materia->id,'comision_id'=>$comision->id]) }}"
               class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Planilla</a>-->
        @else
        <!---
            <a href="{{ route('excel.procesos',['materia_id'=>$materia->id]) }}" class="btn btn-sm btn-success">Descargar
                Planilla</a>-->

        @endif --}}
        <a href="{{ route('proceso_modular.list', ['materia'=> $materia->id,'ciclo_lectivo' => $ciclo_lectivo, 'cargo_id'=> $cargo->id]) }}"
           class="btn btn-secondary">
            Ver Módulo {{$materia->nombre}}
        </a>

        @if(count($procesos) > 0)
            <div class="table-responsive tableFixHead">
                <table class="table mt-4 ">
                    <thead class="thead-dark ">
                    <tr>
                        <th>
                            Alumno
                        </th>
                        @if(count($calificaciones) > 0)
                            @foreach($calificaciones as $calificacion)
                                <th><a href="{{ route('calificacion.create',$calificacion->id) }}"
                                       class="text-white" title="{{$calificacion->description}}"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                    >{{$calificacion->nombre}}</a></th>
                            @endforeach
                        @else
                            <th>
                                -
                            </th>
                        @endif
                        <th>
                            <a href="{{ route('asis.admin', ['id'=> $materia->id,'ciclo_lectivo' => $ciclo_lectivo ,'cargo_id' => $cargo->id])}}"
                               class="text-white"> Asistencia % </a>
                        </th>
                        {{--                        <th>Nota Final</th>--}}

                        <th>
                            Cierre
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($procesos as $proceso)
                        <tr>
                            <td>
                                {{$proceso->alumno->apellidos}}, {{$proceso->alumno->nombres}}
                            </td>
                            @if(count($calificaciones) > 0)
                                @foreach($calificaciones as $cc)
                                    <td>
                                        @if($proceso->procesoCalificacion($cc->id))
                                            <span
                                                class="{{ $proceso->procesoCalificacion($cc->id)->porcentaje >= 60 ? 'text-success' : 'text-danger' }}">
                                                <b>{{$proceso->procesoCalificacion($cc->id)->nota != -1 ? $proceso->procesoCalificacion($cc->id)->nota : 'A'}}</b>
                                                <small>
                                ({{$proceso->procesoCalificacion($cc->id)->porcentaje != -1 ? $proceso->procesoCalificacion($cc->id)->porcentaje : 'A'}}

                                                    @if($proceso->procesoCalificacion($cc->id)->porcentaje >= 0)
                                                        %
                                                    @endif
                                                    )</small>
                            </span>


                                            @if($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio)
                                                <span
                                                    class="{{ $proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio >= 60 ? 'text-success' : 'text-danger' }}">
                                                    R: <b>{{$proceso->procesoCalificacion($cc->id)->nota_recuperatorio}}</b>
                                                    <small>({{$proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio}}
                                                        @if(is_numeric($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio))
                                                            %
                                                        @endif
                                                        )
                                                    </small>
                            </span>

                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            @else
                                <td>
                                    -
                                </td>
                            @endif
                            <td>
                                {{ $proceso->asistencia() ? optional($proceso->asistencia()->getByAsistenciaCargo($cargo->id))->porcentaje : '-' }}
                                %
                            </td>
                            {{--                            <td>--}}
                            {{--                                <form action="" id="{{ $proceso->id }}">--}}
                            {{--                                    <input type="number"--}}
                            {{--                                           class="form-control nota_final {{ $proceso->final_calificaciones >= 4 ? 'text-success' : 'text-danger' }}"--}}
                            {{--                                           id="nota-{{ $proceso->id }}"--}}
                            {{--                                           value="{{ $proceso->final_calificaciones ? $proceso->final_calificaciones : '' }}"--}}
                            {{--                                           @if($proceso->cierre || !$proceso->estado_id) disabled @endif>--}}
                            {{--                                    <button type="submit"--}}
                            {{--                                            class="btn btn-info btn-sm col-md-12 input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">--}}
                            {{--                                        <i class="fa fa-save"></i></button>--}}
                            {{--                                </form>--}}
                            {{--                            </td>--}}
                            <td>
                                <span class="d-none" id="span-{{$proceso->id}}">
                                    <small style="font-size: 0.6em" class="text-success">Cambio realizado</small>
                                </span>
                                <span class="d-none" id="spin-{{$proceso->id}}">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span>
                                    {{$proceso->id}}<br/>
                                    {{$proceso->cierre}}
                                     @if ($proceso->cierre == 1)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <input type="checkbox" class="check-cierre"
                                               id="{{$proceso->id}}"
                                               {{$proceso->obtenerProcesoCargo($cargo->id) ? 'checked':'unchecked'}}
                                               data-tipo="modular"
                                               data-cargo="{{$cargo->id}}"
                                        >
                                    @endif

                                </span>


                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                    @else
                        'No se encontraron procesos'
                @endif
            </div>
            @endsection
            @section('scripts')
                <script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>
                <script>


                </script>

@endsection
