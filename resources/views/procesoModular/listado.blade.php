@extends('layouts.app-prueba')
@section('content')
    <style>
        table {
            font-size: 0.85em;
        }

        .table-responsive {
            height: 800px;
            overflow: scroll;
        }

        .fijar {
            background: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .thead-dark th {
            color: white;
            background-color: #343a40;
            border-color: rgba(52, 58, 64, 0.75);
        }

    </style>
    <div class="container-fluid w-100" id="container-scroll">
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
                        Ciclo lectivo {{$ciclo_lectivo}}
                    </button>
                    <ul class="dropdown-menu">
                        @for ($i = $changeCicloLectivo[1]; $i >= $changeCicloLectivo[0]; $i--)
                            <li>
                                <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif "
                                   href="{{ route('proceso_modular.list',
                                    ['materia'=> $materia->id,'ciclo_lectivo' => $i, 'cargo_id'=> $cargo_id]) }}">
                                    {{$i}}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>

        @if($acciones)
            <div>
                @foreach($acciones as $accion)
                    <span class="invalid-feedback d-block" role="alert">
                        {{$accion}}
                    </span>
                @endforeach
            </div>
        @endif
        <div class="row-cols-1">
            <div class="card w-75 mx-auto">
                <div class="card-header text-center text-primary">
                    <div class="card-title">
                        Notas de Proceso Módulo <u>{{ $materia->nombre }}</u>
                    </div>
                    <div class="card-subtitle">
                        <p>Año: {{$materia->año}}° - Carrera: {{$materia->carrera->nombre}}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="blockquote blockquote-footer mt-1 mb-0">
                        Prof.: {{$materia->getProfesoresModulares()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                @if(Session::has('coordinador') || Session::has('admmin') || Session::has('seccionAlumnos') )
                    <h6> Cargos: </h6>
                    @foreach($materia->cargos()->get() as $cargo)
                        <a href="{{ route('proceso.listadoCargo',
                                ['materia_id'=> $materia->id, 'cargo_id' => $cargo->id]) }}"
                           class="btn btn-info btn-sm" title="Ver proceso cargo">
                            {{$cargo->nombre}}
                            @if(Session::has('admin'))
                                {{$cargo->id}}
                            @endif
                        </a>
                    @endforeach

                @endif
            </div>

        </div>
        <div id="alerts">
        </div>
        <div class="d-flex alert alert-info w-75 mx-auto">
            <div class="row m-0 p-0">
                <div class="me-auto col-sm-3">
                    <small><strong><i>Importante: </i></strong></small>
                </div>
                <div class="col-sm-9">
                    <small class="mb-1"><i><small>
                                Los datos <b><i>no son definitivos</i></b> a menos que los procesos estén cerrados.
                                Los procesos se editan desde cada cargo individualmente.

                                @if($puede_procesar)
                                    <br/><b>Usted tiene permisos de edición</b>
                                @endif
                            </small></i></small>
                </div>
                <div class="me-auto col-sm-3">
                    <small><strong><i>
                                <u>Aclaraciones:</u>
                            </i></strong></small>
                </div>
                <div class="col-sm-9">
            <span class="col-sm-12 m-0">
                <small>
                <b>'N Proceso'</b>: <i>Nota Proceso.</i>
                <b>'% Asist. Final'</b>: <i>Porcentaje Asistencia Final.</i>
                <b>'N TFI'</b>: <i>Nota Trabajo Final Integrador.</i>
                <b>'N Final'</b>: <i>Nota Final.</i>
                </small>
            </span>
                    <br/>
                    <span class="col-sm-12 m-0">
                        <small>
                <b>'N Global'</b>: <i>Nota Global.</i>
                <b>'% Act. Ap.'</b>: <i>Porcentaje de actividades del cargo aprobadas.</i>
                <b>'TP's'</b>: <i>Trabajos Prácticos.</i>
                <b>'N TPs x̄'</b>: <i>Nota Promedio Trabajos Prácticos.</i>
                        </small>
                </span><br/>
                    <span class="col-sm-12 m-0">
                        <small>
                <b>'N Ps x̄'</b>: <i>Nota Promedio Parciales.</i>
                <b>'P's'</b>: <i>Parciales.</i>
                <b>'% Asist.'</b>: <i>Porcentaje asistencia.</i>
                        </small>
                </span>
                </div>
            </div>
        </div>

        @if(isset($comision))

            <a href="{{route('excel.procesosModular',[
                    'materia_id'=>$materia->id,
                    'ciclo_lectivo'=>$ciclo_lectivo,
                    'comision_id'=>$comision->id
                    ])}}"
               class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar planilla</a>
        @else

            <a href="{{route('excel.procesosModular',['materia_id'=>$materia->id,'ciclo_lectivo' => $ciclo_lectivo])}}"
               class="btn btn-sm btn-success"><i
                    class="fas fa-download"></i> Descargar
                planilla</a>
        @endif
        {{--
            @if($puede_procesar)
                <a href="{{ route('proceso.cambiaCierreGeneral', ['materia_id'=> $materia->id, 'cargo_id' => $cargo_id,'comision_id' => 0 ,'cierre_coordinador' => true]) }}"
                   class="btn btn-warning">
                    Cerrar Notas
                </a>
            @endif

        @endif --}}
        @if($cargo_id)
            @inject('cargoService', 'App\Services\CargoService')
            {{--            @if($cargoService->getResponsableTFI($cargo_id, $materia->id) == 1)--}}
            @if($puede_procesar)
                <a href="{{route('proceso_modular.procesa_estados_modular',['materia'=>$materia->id,'ciclo_lectivo'=>$ciclo_lectivo, 'cargo_id' => $cargo_id])}}"
                   class="btn btn-sm btn-info">Calcula Regularidad</a>
            @endif
        @endif

        @if(count($procesos) > 0)
            <div class="table-responsive mt-2">
                <table class="table table-hover" id="job-table">
                    <thead class="thead-dark text-white" style="z-index: 100">
                    <tr class="fijar">
                        <th class="sticky-top">
                            Alumno
                        </th>
                        {{--                        <th class="sticky-top">Proc. Final %</th>--}}
                        <th class="sticky-top text-center">N Proceso</th>
                        <th class="sticky-top text-center">% Asist. Final</th>
                        {{--                        <th class="sticky-top">TFI %</th>--}}
                        <th class="sticky-top text-center">N TFI</th>
                        {{--                        <th class="sticky-top">Nota Final %</th>--}}
                        <th class="sticky-top text-center">N Final</th>
                        <th class="sticky-top col-sm-1">N Global</th>
                        <th class="sticky-top">Cierre</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($procesos as $proceso)
                        @if($proceso->procesoRelacionado)
                            <tr class="bg-secondary text-white font-weight-bold">
                                <td>
                                    {{optional($proceso->procesoRelacionado->alumno)->apellidos_nombres}}
                                </td>
                                <td class="text-center">
                                    @colorAprobado($proceso->promedio_final_nota)
                                </td>
                                <td class="text-center">
                                    {{$proceso->asistencia_final_porcentaje}} %
                                </td>
                                <td class="text-center">
                                    @colorAprobado($proceso->trabajo_final_nota)
                                </td>
                                <td class="text-center">
                                    @colorAprobado($proceso->nota_final_nota)
                                </td>
                                <td class="row">
                                    <form action="" id="{{ $proceso->procesoRelacionado->id }}"
                                          class="form_nota_global">
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control btn-sm nota_global
                                                   @classAprobado($proceso->procesoRelacionado->nota_global)"
                                                   id="global-{{ $proceso->procesoRelacionado->id }}"
                                                   value="{{ $proceso->procesoRelacionado->nota_global != -1 ?
                                                            $proceso->procesoRelacionado->nota_global : 'A' }}"
                                                   @if(($proceso->procesoRelacionado->estado
                                                        && ($proceso->procesoRelacionado->estado->identificador != 5
                                                        || $proceso->procesoRelacionado->estado->identificador != 7))
                                                        || !$puede_procesar
                                                        || $proceso->procesoRelacionado->cierre)
                                                       disabled
                                                @endif>
                                            <div class="input-group-append">
                                                <button type="submit"
                                                        class="btn btn-info btn-sm input-group-text"
                                                        id="btn-global-{{ $proceso->procesoRelacionado->id }}"
                                                        @if(!Session::has('profesor') or
                                                            $proceso->procesoRelacionado->cierre)
                                                            disabled
                                                    @endif>
                                                    <i class="fa fa-save"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <input type="checkbox" class="check-cierre"
                                           id="{{$proceso->procesoRelacionado->id}}"
                                           @if($proceso->procesoRelacionado->cierre == 1)
                                               checked
                                           @else
                                               unchecked
                                        @endif
                                    />
                                </td>
                            </tr>
                            <tr class="bg-secondary text-white font-weight-bold">
                                <td>
                                    <small>
                                        <small>Condición:
                                            @if($proceso->procesoRelacionado->estado)
                                                @if($proceso->procesoRelacionado->estado->regularidad)
                                                    {{$proceso->procesoRelacionado->estado->regularidad}}
                                                @else
                                                    {{$proceso->procesoRelacionado->estado->nombre}}
                                                @endif
                                            @else
                                                No indicada
                                            @endif
                                        </small>
                                    </small>
                                </td>
                                <td colspan="2" class="text-center w-50">

                                    @if($puede_procesar)
                                        <div class="d-inline-flex ml-3">
                                            <label for="{{$proceso->procesoRelacionado->id}}" class="mr-2">
                                                <small><sup>*</sup> Cambiar condición</small>
                                            </label>
                                            <select name="estado" class="custom-select custom-select-sm select-estado"
                                                    id="{{$proceso->procesoRelacionado->id}}"
                                                    @if(!$puede_procesar || $proceso->procesoRelacionado->cierre == 1) disabled=disabled
                                                    @endif
                                                    data-estado="{{$proceso->procesoRelacionado->id}}">
                                                @foreach($estados as $estado)
                                                    <option value="{{ $estado->id }}"
                                                            @if(optional($proceso->procesoRelacionado->estado)->id === $estado->id)
                                                                selected="selected"
                                                        @endif
                                                    >
                                                        {{ $estado->nombre }}

                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center" colspan="2">
                                    <a href="{{route('proceso_modular.procesa_notas_modular', ['materia' => $materia->id, 'proceso_id' => $proceso->procesoRelacionado->id, 'cargo' => $cargo_id ])}}"
                                       class="btn btn-sm btn-primary text-white" style="font-size: 0.8em">
                                        Comprobar notas
                                    </a>
                                    <span class="d-none" id="span-{{$proceso->procesoRelacionado->id}}">
                                    <small style="font-size: 0.8em" class="bg-success p-1">Cambio realizado</small>
                                </span>
                                    {{--                                <span class="d-none" id="span-{{$proceso->procesoRelacionado->id}}">--}}
                                    {{--                                    <small style="font-size: 0.6em" class="text-white">Cambio realizado</small>--}}
                                    {{--                                </span>--}}

                                    <span class="d-none" id="spin-{{$proceso->procesoRelacionado->id}}">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>
                                </td>

                                <td colspan="2">
                                    <button type="button" class="btn btn-sm btn-primary"
                                            data-bs-toggle="collapse" data-bs-target="#cargo-{{$proceso->id}}">
                                        Cargos <i class="fas fa-caret-square-down"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="border-top-0 border-info">
                                    <div id="cargo-{{$proceso->id}}" class="collapse p-0 m-0">
                                        @include('proceso.listado-cargos-modulo', ['alumno' => $proceso->procesoRelacionado->alumno, 'cargos' => $materia->cargos ])
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                    {{--                    @include('proceso.modals.tps-mostrar')--}}
                    @else
                        'No se encontraron procesos'
                @endif

            </div>
            @endsection
            @section('scripts')
                <script src="{{ asset('js/proceso/cambia_cierre_modular.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>
                <script src="{{ asset('js/proceso/ver_tps.js') }}"></script>

@endsection
