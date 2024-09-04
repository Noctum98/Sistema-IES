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

        small {
            font-size: 0.75em;
        }

        .custom-input {
            width: 60px !important;
        }
    </style>
    @if (session('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{{ session('error') }}</li>
            </ul>
        </div>
    @endif
    <div class="container-fluid" id="container-scroll">
        <div class="row m-0">
            <div class="col-sm-6 text-left">
                <a href="{{url()->previous()}}">
                    <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
                </a>
            </div>

            <div class="col-sm-6 text-right">
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1"
                            data-bs-toggle="dropdown">
                        Ciclo lectivo <span id="ciclo_lectivo">{{$ciclo_lectivo}}</span>
                    </button>
                    <ul class="dropdown-menu">
                        @for ($i = $changeCicloLectivo[1]; $i >= $changeCicloLectivo[0]; $i--)
                            <li>
                                <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                   href="{{ route('proceso.listado',
                                    ['materia_id'=> $materia->id,'ciclo_lectivo' => $i, 'comision_id'=> $comision ? $comision->id : '']) }}">
                                    {{$i}}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
                <div>
                    <p class="bg-warning p-1 text-dark">Cierre Perentorio: {{$fecha_perentoria->format('d/m/Y')}}</p>
                    @if($materia_cerrada)
                        <p>La planilla no puede modificarse</p>
                    @endif
                </div>
            </div>
        </div>

        <h4 class="text-dark">
            <small>Notas de Proceso de:</small> <i>{{ $materia->nombre}}</i> <sup class="ml-5">{{$materia->año}}°
                año</sup>
            <br/> <small>
                <i>
                    Carrera: <b>{{$materia->carrera->nombre}}, {{$materia->carrera->sede->nombre}}</b>, Ciclo
                    lectivo <b>{{$ciclo_lectivo}}</b>
                </i>
            </small>
            @if($comision)
                <br>
                <small>{{$comision->nombre}}</small>
            @endif
        </h4>
        <hr>
        <div id="alerts">
        </div>
        <div class="alert alert-info">
            <strong><i>Importante:</i></strong><br/>
            <i class="ml-5">Después de la letra R se muestra la nota del recuperatorio, solo en el caso de los
                Parciales.</i><br/>
            <i class="ml-5">Al hacer clic en el nombre de la calificación, redirige a la misma.</i><br/>
            <i class="ml-5">Al posar el mouse sobre el nombre de la calificación, muestra el nombre
                completo.</i><br/>
            <i class="ml-5">Al hacer clic sobre la nota de Promedio TP se podrán ver todos los Trabajos
                Prácticos.</i>
        </div>

        <a href="{{ route('proceso.libres',$materia->id) }}" class="btn btn-sm btn-primary">Ver Libres</a>

        @if(count($procesos) > 0)
            @if($comision)
                <a href="{{ route('excel.procesos',['materia_id'=>$materia->id,'ciclo_lectivo'=>$ciclo_lectivo,'comision_id'=>$comision->id]) }}"
                   class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar Planilla</a>
            @else
                <a href="{{ route('excel.procesos',['materia_id'=>$materia->id,'ciclo_lectivo'=>$ciclo_lectivo]) }}"
                   class="btn btn-sm btn-success"> <i class="fas fa-download"></i> Descargar Planilla</a>
            @endif

            @if(Session::has('coordinador') || Session::has('admin'))
                <button data-bs-toggle="modal" data-bs-target="#cerrarPlanilla" class="btn btn-sm btn-warning"> Cerrar
                    Planilla
                </button>
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
                                <th><a href="{{ route('calificacion.create',$calificacion->id) }}"
                                       title="{{$calificacion->nombre}}" class="text-white">
                                        {{ substr($calificacion->nombre, 0, 9) }}
                                        {{ strlen($calificacion->nombre) > 9 ? '...' : '' }}
                                    </a></th>
                            @endforeach
                        @endif
                        <th><a href="{{ route('asis.inicio') }}" class="text-white"> Asistencia % </a></th>
                        @if($materia->etapa_campo)
                            <th>Etapa Campo</th>
                        @endif
                        <th>
                            Condición
                        </th>
                        <th>Nota Global</th>

                        <th>
                            Cierre
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($procesos as $proceso)
                        <tr
                            @if($proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo))
                                class="text-muted"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{$proceso->alumno()->first()->infoEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo)}}"
                            @endif
                        >
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
                                            <span
                                                class="badge {{ $proceso->procesoCalificacion($cc->id)->porcentaje >= 60 ? 'badge-success' : 'badge-danger' }}">
                                        {{$proceso->procesoCalificacion($cc->id)->porcentaje != -1 ? $proceso->procesoCalificacion($cc->id)->porcentaje : 'A'}}
                                    </span>
                                            @if($proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio)
                                                <span
                                                    class="badge {{ $proceso->procesoCalificacion($cc->id)->porcentaje_recuperatorio >= 60 ? 'badge-success' : 'badge-danger' }}">
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
                                    @if(!$proceso->habilitado_campo)
                                        <button class="btn btn-sm btn-info modals-cargar" data-bs-toggle="modal"
                                                data-bs-target="#etapaCampo" id="{{$proceso->id}}"
                                                data-campo="{{$proceso->etapaCampo ? $proceso->etapaCampo->id : null }}"
                                                data-habilitado="{{$proceso->habilitado_campo}}">Habilitar/Cargar
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-success modals-cargar" data-bs-toggle="modal"
                                                data-bs-target="#etapaCampo" id="{{$proceso->id}}"
                                                data-campo="{{$proceso->etapaCampo ? $proceso->etapaCampo->id : null }}"
                                                data-habilitado="{{$proceso->habilitado_campo}}">Cargar
                                        </button>
                                    @endif
                                </td>
                            @endif
                            <td class="col-md-3">
                                <select class="custom-select select-estado col-md-12" name="estado-{{$proceso->id}}"
                                        id="{{$proceso->id}}" data-proceso_id="{{ $proceso->id }}"
                                        @if(!$proceso->habilitadoCierre($materia_cerrada) || $proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo))
                                            disabled
                                    @endif
                                >
                                    <option value="">Seleccione condición</option>
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
                                @if(!$proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo))
                                    <form action="" id="{{ $proceso->id }}" class="input-group form_nota_global">
                                        @if($proceso->nota_global)
                                            <input type="text" class="form-control nota_global custom-input @include('componentes.classNota',
                        ['year' => $ciclo_lectivo,
                        'nota' => $proceso->nota_global ])"
                                                   id="global-{{ $proceso->id }}"
                                                   value="{{ $proceso->nota_global > 0 ? $proceso->nota_global : 'A' }}"
                                                   @if(!$proceso->estado || ($proceso->estado && $proceso->estado->identificador != 5) || $proceso->cierre) disabled @endif>
                                        @else
                                            <input type="text" class="form-control nota_global custom-input @include('componentes.classNota',
                        ['year' => $ciclo_lectivo,
                        'nota' => $proceso->nota_global ])"
                                                   id="global-{{ $proceso->id }}" value=""
                                                   @if(!$proceso->estado || ($proceso->estado && $proceso->estado->identificador != 5) || $proceso->cierre) disabled @endif>
                                        @endif
                                        <button type="submit" class="btn btn-info btn-sm input-group-text"
                                                id="btn-global-{{ $proceso->id }}"
                                                @if(!Session::has('profesor') || $proceso->cierre || $materia->cierre) disabled @endif >
                                            <i class="fa fa-save"></i></button>
                                    </form>
                                @endif
                            </td>
                            <td>
                        <span class="d-none" id="span-{{$proceso->id}}">
                            <small style="font-size: 0.6em" class="text-success">Cambio realizado</small>
                        </span>
                                <span class="d-none" id="spin-{{$proceso->id}}">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>

                                <input type="hidden" name="checkcoordinador" id="coordinador"
                                       value="{{ Session::has('coordinador') ? 1 : 0 }}">

                                <input type="checkbox" class="check-cierre"
                                       id="{{$proceso->id}}" {{$proceso->cierre == false ? 'unchecked':'checked'}} {{ !$proceso->habilitadoCierre($materia_cerrada) ? 'disabled' : '' }}>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                    @include('proceso.modals.tps-mostrar')
                    @else
                        <p> No se encontraron procesos </p>
                @endif
                @include('proceso.modals.cargar_etapa_campo')

            </div>
            @include('proceso.modals.cerrar_planilla')

            @endsection
            @section('scripts')
                <script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>
                <script src="{{ asset('js/proceso/calcular_porcentaje.js') }}"></script>
                <script src="{{ asset('js/proceso/ver_tps.js') }}"></script>
                <script src="{{ asset('js/etapa_campo/cargar.js') }}"></script>

@endsection
