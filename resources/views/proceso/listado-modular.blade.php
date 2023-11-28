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
    <div class="container-fluid" id="container-scroll">

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
                                       href="{{ route('proceso.listadoCargo',
['materia_id'=> $materia->id, 'cargo_id' => $cargo->id,'ciclo_lectivo' => $i ,'comision_id' => $comision->id]) }}">
                                        {{$i}}
                                    </a>
                                @else
                                    <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                       href="{{ route('proceso.listadoCargo',
['materia_id'=> $materia->id, 'cargo_id' => $cargo->id,'ciclo_lectivo' => $i ]) }}">
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
        <div class="d-flex alert alert-info w-100 mx-auto">
            <div class="col-sm-2">
                <span><strong><i>Importante:</i></strong></span>
            </div>
            <div>
                <small><i>Después de la letra R se muestra la nota del recuperatorio, solo en el caso de los
                        Parciales.</i></small><br/>
                <small><i>Al hacer clic en el nombre de la calificación, redirige a la misma.</i></small>
                <br/>
                <small>
                    <i class="fa fa-plus mr-2"
                       title="Por favor haga clic aquí para agregar al alumno a la planilla modular">
                    </i>
                    Este signo avisa que el alumno no tiene las notas cargadas  en planilla modular.
                    Por favor haga clic en el mismo.
                </small>
                <br/>
                <small>
                    <i class="fa fa-upload mr-2"
                       title="Por favor haga clic aquí para actualizar planilla modular">
                    </i>
                    Para mantener actualizadas las notas en la planilla modular por favor presione el botón
                </small>
                <br/>
            </div>
        </div>

        <a href="{{ route('proceso_modular.list',
['materia'=> $materia->id,'ciclo_lectivo' => $ciclo_lectivo, 'cargo_id'=> $cargo->id]) }}"
           class="btn btn-secondary">
            Ver Módulo {{$materia->nombre}}
        </a>

        @if(count($procesos) > 0)
            <div class="table-responsive tableFixHead">
                <table class="table mt-4" aria-describedby="tabla de notas del cargo">
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
                            <a href="{{ route('asis.admin',
['id'=> $materia->id,'ciclo_lectivo' => $ciclo_lectivo ,'cargo_id' => $cargo->id])}}"
                               class="text-white"> Asistencia % </a>
                        </th>
                        <th>N. Final /<br/>
                            <small style="font-size: 0.8em">(Ponderación)</small>
                        </th>
                        <th>
                            <i class="fa fa-upload"></i>
                        </th>
                        <th>
                            Cerrar notas
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
                                                class="{{ $proceso->procesoCalificacion(
    $cc->id)->porcentaje >= 60 ? 'text-success' : 'text-danger' }}">
                                                <b>{{$proceso->procesoCalificacion(
    $cc->id)->nota != -1 ? $proceso->procesoCalificacion($cc->id)->nota : 'A'}}</b>
                                                <small>
                                                    <br/>
                                                    (
                                                    {{$proceso->procesoCalificacion(
    $cc->id)->porcentaje != -1 ? $proceso->procesoCalificacion($cc->id)->porcentaje : 'A'}}
                                                    @if($proceso->procesoCalificacion(
    $cc->id)->porcentaje >= 0)
                                                        %
                                                    @endif
                                                    )
                                                </small>
                            </span>

                                            @if($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio)
                                                <span
                                                    class="{{ $proceso->procesoCalificacion(
    $cc->id)->porcentaje_recuperatorio >= 60 ? 'text-success' : 'text-danger' }}">
                                                    R: <b>{{$proceso->procesoCalificacion(
    $cc->id)->nota_recuperatorio}}</b>
                                                    <small>
                                                        <br/>
                                                        ({{$proceso->procesoCalificacion(
    $cc->id)->porcentaje_recuperatorio}}
                                                        @if(is_numeric($proceso->procesoCalificacion(
    $cc->id)->porcentaje_recuperatorio))
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
                                {{ $proceso->asistencia() ?
optional($proceso->asistencia()->getByAsistenciaCargo($cargo->id))->porcentaje : '-' }}
                                %

                            </td>
                            <td class="text-center">
                                @if($proceso->getCargosProcesos($cargo->id))
                                    {{$proceso->getCargosProcesos($cargo->id)->nota_cargo}}<br/>
                                    <small
                                        style="font-size: 0.8em">
                                        ({{$proceso->getCargosProcesos($cargo->id)->nota_ponderada}})
                                    </small>
                                @else
                                    <a href="{{route('cargo_proceso.store',
['proceso_id' => $proceso->id, 'cargo_id' => $cargo->id])}}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus" title="Por favor haga clic aquí"></i>

                                    </a>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($proceso->getCargosProcesos($cargo->id))
                                    <a href="{{route('cargo_proceso.actualizar',
['cargo_proceso' => $proceso->getCargosProcesos($cargo->id)])}}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-upload" title="Por favor actualice haciendo clic aquí"></i>
                                    </a>
                                @else
                                    <small><i class="fa fa-arrow-left"></i> </small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="d-none" id="span-{{$proceso->id}}">
                                    <small style="font-size: 0.6em" class="text-success">Cambio realizado</small>
                                </span>
                                <span class="d-none" id="spin-{{$proceso->id}}">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                <span>
                                     @if ($proceso->cierre == 1)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <label for="{{$proceso->id}}"></label>
                                        <input type="checkbox" class="check-cierre"
                                               id="{{$proceso->id}}"
                                               @if($proceso->obtenerProcesoCargo($cargo->id))
                                                   {{$proceso->obtenerProcesoCargo($cargo->id)->isClose() ?
                                                    'checked':'unchecked'}}
                                               @endif
                                               data-tipo="modular" data-cargo="{{$cargo->id}}"
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
{{--                <script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>--}}
                <script src="{{ asset('js/proceso/cambia_cierre_modular.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>
                <script>


                </script>

@endsection
