@extends('layouts.app-prueba')
@section('content')
<style>
    thead Th {
        position: sticky;
        z-index: 1;
        top: 0;
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
    <p><i>Al hacer click en el nombre de la calificación, redirige a la misma.</i></p>

    @if($comision)
    <a href="{{ route('excel.procesos',['materia_id'=>$materia->id,'comision_id'=>$comision->id]) }}" class="btn btn-sm btn-success">Descargar Planilla</a>
    @else
    <a href="{{ route('excel.procesos',['materia_id'=>$materia->id]) }}" class="btn btn-sm btn-success">Descargar Planilla</a>

    @endif
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
                    <th><a href="{{ route('calificacion.create',$calificacion->id) }}" class="text-white">{{$calificacion->nombre}}</a></th>
                    @endforeach
                    @endif
                    <th> <a href="{{ route('asis.inicio') }}" class="text-white"> Asistencia % </a></th>
                    <th>
                        Estado
                    </th>
                    <th>Nota Final</th>

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
                        {{ $proceso->asistencia() ? $proceso->asistencia()->porcentaje_final : '-' }} %
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
                        <form action="" id="{{ $proceso->id }}">
                            <input type="number" class="form-control nota_final {{ $proceso->final_calificaciones >= 4 ? 'text-success' : 'text-danger' }}" id="nota-{{ $proceso->id }}" value="{{ $proceso->final_calificaciones ? $proceso->final_calificaciones : '' }}" 
                            @if($proceso->cierre || !$proceso->estado_id) disabled @endif>
                            <button type="submit" class="btn btn-info btn-sm col-md-12 input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">
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
            @else
            'No se encontraron procesos'
            @endif
            {{-- <div class="col-md-4 m-0 p-0 proceso-detalle">--}}
            {{-- <ul>--}}
            {{-- <li><strong>Materia:</strong> {{ $proceso->materia->nombre }}</li>--}}
            {{-- <li><strong>Estado:</strong> {{ ucwords($proceso->estado) }}</li>--}}
            {{-- <li><strong>Nota final de parciales:</strong>--}}
            {{-- {{ $proceso->final_parciales ? $proceso->final_parciales : 'Sin asignar'}}--}}
            {{-- </li>--}}
            {{-- <li><strong>Nota final de TP:</strong>--}}
            {{-- {{ $proceso->final_trabajos ? $proceso->final_trabajos : 'Sin asignar'}}--}}
            {{-- </li>--}}
            {{-- <li><strong>Asistencia final:</strong>--}}
            {{-- {{ $proceso->final_asistencia ? $proceso->final_asistencia : 'Sin asignar'}}--}}
            {{-- </li>--}}
            {{-- </ul>--}}
            {{-- </div>--}}
    </div>
    @endsection
    @section('scripts')
    <script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>
    <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>
    <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>

    @endsection