@extends('layouts.app-prueba')
@section('content')
    <style>
        thead th {
            position: sticky;
            z-index: 1;
            top: 0;
        }
    </style>
    <div class="container" id="container-scroll">
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
        <h3 class="text-info">
            Notas de Proceso de {{ $cargo->nombre }} @if($comision)
                <br/><small>{{$comision->nombre}}</small>
            @endif
        </h3>
        <h5>
            Correspondiente al módulo <i>{{$materia->nombre}}</i>
        </h5>
        <hr>
        <div id="alerts">

        </div>
        <p><strong><i>Importante:</i></strong></p>
        <p><i>Después de la letra R se muestra la nota del recuperatorio, solo en el caso de los Parciales.</i></p>
        <p><i>Al hacer clic en el nombre de la calificación, redirige a la misma.</i></p>
{{--
        @if($comision)
            <a href="{{ route('excel.procesos',['materia_id'=>$materia->id,'comision_id'=>$comision->id]) }}"
               class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Planilla</a>
        @else
            <a href="{{ route('excel.procesos',['materia_id'=>$materia->id]) }}" class="btn btn-sm btn-success">Descargar
                Planilla</a>

        @endif --}}
        <a href="{{ route('proceso_modular.list', ['materia'=> $materia->id, 'cargo_id'=> $cargo->id]) }}"
           class="btn btn-secondary">
            Ver Módulo {{$materia->nombre}}
        </a>
{{--        <a href="{{ route('proceso.cambiaCierreGeneral', ['materia_id'=> $materia->id, 'cargo_id'=> $cargo->id]) }}"--}}
{{--           class="btn btn-warning">--}}
{{--            Cerrar Notas {{ $cargo->nombre }} @if($comision)<br/><small>{{$comision->nombre}}</small>@endif--}}
{{--        </a>--}}
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
                                       class="text-white">{{$calificacion->nombre}}</a></th>
                            @endforeach
                        @else
                            <th>
                                -
                            </th>
                        @endif
                        <th>
                            <a href="{{ route('asis.admin', ['id'=> $materia->id, 'cargo_id' => $cargo->id])}}" class="text-white"> Asistencia % </a>
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
                                            <span class="{{ $proceso->procesoCalificacion($cc->id)->porcentaje >= 60 ? 'text-success' : 'text-danger' }}">
                                {{$proceso->procesoCalificacion($cc->id)->porcentaje != -1 ? $proceso->procesoCalificacion($cc->id)->porcentaje : 'A'}}
                            </span>
                                            @if($proceso->procesoCalificacion($cc->id)->porcentaje >= 0)
                                                %
                                            @endif

                                            @if($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio)
                                                <span class="{{ $proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio >= 60 ? 'text-success' : 'text-danger' }}">
                                R: {{$proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio}}
                            </span>
                                                @if(is_numeric($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio))
                                                    %
                                                @endif
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

                                <input type="checkbox" class="check-cierre"
                                       id="{{$proceso->id}}" {{$proceso->obtenerProcesoCargo($cargo->id) ? 'checked':'unchecked'}}
                                        data-tipo="modular"
                                       data-cargo="{{$cargo->id}}"
                                >
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

@endsection
