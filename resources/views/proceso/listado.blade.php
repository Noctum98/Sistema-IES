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
@if (session('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ session('error') }}</li>
        </ul>
    </div>
@endif
<div class="container" id="container-scroll">
    <a href="{{url()->previous()}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
    <h2 class="h1 text-info">
        Notas de Proceso de {{ $materia->nombre.' ('.$ciclo_lectivo.')' }} @if($comision)
        <br /><small>{{$comision->nombre}}</small>
        @endif
    </h2>
    <hr>
    <div id="alerts">

    </div>
    <p><strong><i>Importante:</i></strong></p>
    <p class="text-primary"><i>Después de la letra R se muestra la nota del recuperatorio, solo en el caso de los Parciales.</i></p>
    <p class="text-primary"><i>Al hacer clic en el nombre de la calificación, redirige a la misma.</i></p>
    <p class="text-primary"><i>Al posar el mouse sobre el nombre de la calificación, muestra el nombre completo.</i></p>
    <p class="text-primary"><i>Al hacer clic sobre la nota de Promedio TP se podrán ver todos los Trabajos Prácticos.</i></p>


    @if(count($procesos) > 0)
    @if($comision)
    <a href="{{ route('excel.procesos',['materia_id'=>$materia->id,'ciclo_lectivo'=>$ciclo_lectivo,'comision_id'=>$comision->id]) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Planilla</a>
    @else
    <a href="{{ route('excel.procesos',['materia_id'=>$materia->id,'ciclo_lectivo'=>$ciclo_lectivo]) }}" class="btn btn-sm btn-success"> <i class="fas fa-download"></i> Descargar Planilla</a>
    @endif

    @if(Session::has('coordinador') || Session::has('admin'))
        @if(!$comision)
        <a href="{{ route('materia.cierre',['materia_id'=>$materia->id]) }}" class="btn btn-sm btn-warning"> Cerrar Planilla</a>
        @else
        <a href="{{ route('materia.cierre',['materia_id'=>$materia->id,'comision_id'=>$comision->id]) }}" class="btn btn-sm btn-warning"> Cerrar Planilla</a>
        @endif
    @endif

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
                    <th><a href="{{ route('calificacion.create',$calificacion->id) }}"  title="{{$calificacion->nombre}}" class="text-white">
                        {{ substr($calificacion->nombre, 0, 9) }}
                        {{ strlen($calificacion->nombre) > 9 ? '...' : '' }}
                    </a></th>
                    @endforeach
                    @endif
                    <th> <a href="{{ route('asis.inicio') }}" class="text-white"> Asistencia % </a></th>
                    @if($materia->etapa_campo)
                    <th>Etapa Campo</th>
                    @endif
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
                            {{$proceso->procesoCalificacion($cc->id)->porcentaje != -1 ? $proceso->procesoCalificacion($cc->id)->porcentaje : 'A'}}
                        </span>


                        @if($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio)
                        <span class="badge {{ $proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio >= 60 ? 'badge-success' : 'badge-danger' }}">
                            R: {{$proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio}}
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
                    @if($materia->etapa_campo)
                    <td>
                    <button class="btn btn-sm btn-info modals-cargar" data-bs-toggle="modal" data-bs-target="#etapaCampo" id="{{$proceso->id}}" data-campo="{{$proceso->etapaCampo ? $proceso->etapaCampo->id : null }}" data-habilitado="{{$proceso->habilitado_campo}}">Habilitar/Cargar</button>

                    </td>
                    @endif
                    <td class="col-md-3">

                        <select class="custom-select select-estado col-md-12" name="estado-{{$proceso->id}}" id="{{$proceso->id}}" @if($proceso->cierre == 1 || $materia->cierre) disabled @endif >
                            <option value="">Seleccione condición</option>
                            @foreach($estados as $estado)
                            @if($estado->id == $proceso->estado_id)
                            <option value="{{$estado->id}}" selected>{{$estado->nombre}}</option>
                            @else
                            <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                            @endif
                            @endforeach
                        </select>
                        {{-- <button id="observacion-{{$proceso->id}}" class="btn btn-sm btn-warning mt-1 d-none">Observación</button>--}}
                    </td>
                    <td>
                        <form action="" id="{{ $proceso->id }}" class="row form_nota_global col-md-12">
                            @if($proceso->nota_global)
                            <input type="text" class="form-control nota_global {{ $proceso->nota_global >= 4 ? 'text-success' : '' }} {{ $proceso->nota_global < 4 ? 'text-danger' : '' }}" id="global-{{ $proceso->id }}" value="{{ $proceso->nota_global > 0 ? $proceso->nota_global : 'A' }}" @if(!$proceso->estado || ($proceso->estado && $proceso->estado->identificador != 5) || $proceso->cierre) disabled @endif>
                            @else
                            <input type="text" class="form-control nota_global {{ $proceso->nota_global >= 4 ? 'text-success' : '' }} {{ $proceso->nota_global < 4 ? 'text-danger' : '' }}" id="global-{{ $proceso->id }}" value="" @if(!$proceso->estado || ($proceso->estado && $proceso->estado->identificador != 5) || $proceso->cierre) disabled @endif>
                            @endif
                            <button type="submit" class="btn btn-info btn-sm col-md-12 input-group-text" id="btn-global-{{ $proceso->id }}" @if(!Session::has('profesor') || $proceso->cierre || $materia->cierre) disabled @endif >
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

                        <input type="hidden" name="checkcoordinador" id="coordinador" value="{{ Session::has('coordinador') ? 1 : 0 }}">
                        <input type="checkbox" class="check-cierre" id="{{$proceso->id}}" {{$proceso->cierre == false ? 'unchecked':'checked'}} {{ $proceso->cierre && !Session::has('coordinador') ? 'disabled' : '' }}>
                    </td>

                </tr>
                @endforeach
            </tbody>
            @include('proceso.modals.tps-mostrar')
            @else
            'No se encontraron procesos'
            @endif
            @include('proceso.modals.cargar_etapa_campo');

    </div>
    @endsection
    @section('scripts')
    <script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>
    <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>
    <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>
    <script src="{{ asset('js/proceso/calcular_porcentaje.js') }}"></script>
    <script src="{{ asset('js/proceso/ver_tps.js') }}"></script>
    <script src="{{ asset('js/etapa_campo/cargar.js') }}"></script>

    @endsection
