@extends('layouts.app-prueba')
@section('content')
<style>
    thead th {
        position: sticky;
        z-index: 1;
        top: 0;
    }

    table th {
        font-size: 0.9em !important;
        vertical-align: center;
    }
</style>
<div class="container" id="container-scroll">
    <a href="{{url()->previous()}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
    <h2 class="h1 text-info">
        Notas de Proceso de {{ $materia->nombre }} @if($comision)
        <br /><small>{{$comision->nombre}}</small>
        @endif
    </h2>
    <hr>
    <div id="alerts">

    </div>
    <p><strong><i>Importante:</i></strong></p>
    <p><i>Después de la letra R se muestra la nota del recuperatorio, solo en el caso de los Parciales.</i></p>
    <p><i>Al hacer clic en el nombre de la calificación, redirige a la misma.</i></p>
    <p><i>Al clickear sobre la nota de Promedio TP se podrán ver todos los Trabajos Prácticos.</i></p>

    @if($comision)
    <a href="{{ route('excel.procesos',['materia_id'=>$materia->id,'comision_id'=>$comision->id]) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Planilla</a>
    @else
    <a href="{{ route('excel.procesos',['materia_id'=>$materia->id]) }}" class="btn btn-sm btn-success"> <i class="fas fa-download"></i> Descargar Planilla</a>

    @endif
    @if(count($procesos) > 0)
    <div class="table-responsive tableFixHead">

        <table class="table mt-4">
            <thead class="thead-dark ">
                <tr>
                    <th>
                        Alumno
                    </th>
                    <th>Promedio TP</th>
                    @if(count($calificaciones) > 0)
                    @foreach($calificaciones as $calificacion)
                    <th><a href="{{ route('calificacion.create',$calificacion->id) }}" class="text-white">{{$calificacion->nombre}}</a></th>
                    @endforeach
                    @endif
                    <th> <a href="{{ route('asis.inicio') }}" class="text-white"> Asistencia % </a></th>
                    <th>
                        Estado
                    </th>
                    <th>Nota Global</th>

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
                    <td id="tp-{{$proceso->id}}">
                        <span id="tp-spin-{{$proceso->id}}">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </td>
                    @if(count($calificaciones) > 0)
                    @foreach($calificaciones as $cc)
                    <td>
                        @if($proceso->procesoCalificacion($cc->id))
                        <span class="badge {{ $proceso->procesoCalificacion($cc->id)->porcentaje >= 60 ? 'badge-success' : 'badge-danger' }}">
                            {{$proceso->procesoCalificacion($cc->id)->porcentaje != -1 ? $proceso->procesoCalificacion($cc->id)->nota.' - '. $proceso->procesoCalificacion($cc->id)->porcentaje : 'A'}}
                            @if(is_numeric($proceso->procesoCalificacion($cc->id)->porcentaje) && $proceso->procesoCalificacion($cc->id)->porcentaje > 0)
                            %
                            @endif
                        </span>
                       

                        @if($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio)
                        <span class="badge {{ $proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio >= 60 ? 'badge-success' : 'badge-danger' }}">
                            - R: {{$proceso->procesoCalificacion($cc->id)->nota_recuperatorio}}
                        </span>
                       
                        @endif
                        @else
                        -
                        @endif
                    </td>
                    @endforeach
                    @endif
                    <td>
                        <span class="badge badge-secondary">
                            {{ $proceso->asistencia() ? $proceso->asistencia()->porcentaje_final : '-' }} %
                        </span>
                    </td>
                    <td class="col-md-3">

                        <select class="custom-select select-estado col-md-12" name="estado-{{$proceso->id}}" id="{{$proceso->id}}" @if($proceso->cierre == 1) disabled @endif >
                            <option value="">Seleccione estado</option>
                            @foreach($estados as $estado)
                            @if($estado->id == $proceso->estado_id)
                            <option value="{{$estado->id}}" selected>{{$estado->nombre}}</option>
                            @else
                            <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                            @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <form action="" id="{{ $proceso->id }}" class="form_nota_global">
                            <input type="number" class="form-control nota_global {{ $proceso->nota_global >= 4 ? 'text-success' : '' }} {{ $proceso->nota_global < 4 ? 'text-danger' : '' }}" id="global-{{ $proceso->id }}" value="{{ $proceso->nota_global ? $proceso->nota_global : '' }}" @if(($proceso->estado && $proceso->estado->identificador != 5) || $proceso->cierre) disabled @endif>
                            <button type="submit" class="btn btn-info btn-sm col-md-12 input-group-text" id="btn-global-{{ $proceso->id }}" @if(!Session::has('profesor') or $proceso->cierre) disabled @endif>
                                <i class="fa fa-save"></i></button>
                        </form>
                    </td>
                    <td>
                        <span class="d-none" id="span-{{$proceso->id}}">
                            <small style="font-size: 0.6em" class="text-success">Cambio realizado</small>
                        </span>
                        <span class="d-none" id="spin-{{$proceso->id}}">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>

                        <input type="checkbox" class="check-cierre" id="{{$proceso->id}}" {{$proceso->cierre == false ? 'unchecked':'checked'}}>
                    </td>

                </tr>
                @endforeach
            </tbody>
            @include('proceso.modals.tps-mostrar')
            @else
            'No se encontraron procesos'
            @endif
    </div>
    @endsection
    @section('scripts')
    <script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>
    <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>
    <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>
    <script src="{{ asset('js/proceso/calcular_porcentaje.js') }}"></script>
    <script src="{{ asset('js/proceso/ver_tps.js') }}"></script>
    @endsection