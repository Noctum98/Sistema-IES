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
    </style>
    <div class="container-fluid w-100" id="container-scroll">
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
        @if($acciones)
            <div>
                @foreach($acciones as $accion)
                    <span class="invalid-feedback d-block" role="alert">
                        {{$accion}}
                    </span>
                @endforeach
            </div>
        @endif

        <h3 class="text-info">
            Notas de Proceso del Módulo <u>{{ $materia->nombre }}</u>
        </h3>
        @if(Session::has('coordinador') || Session::has('admmin') || Session::has('seccionAlumnos') )
            <h5>
                Cargos:
                @foreach($materia->cargos()->get() as $cargo)
                    <a href="{{ route('proceso.listadoCargo', ['materia_id'=> $materia->id, 'cargo_id' => $cargo->id]) }}"
                       class="btn btn-info" title="Ver proceso cargo">
                        {{$cargo->nombre}}
                        @if(Session::has('admin'))
                            {{$cargo->id}}
                        @endif
                    </a>
                @endforeach
            </h5>
        @endif
        <hr>
        <div id="alerts">
        </div>
        <p><strong><i>Importante:</i></strong></p>
        <p><i><small>
                    Los datos <b><i>no son definitivos</i></b> a menos que los procesos estén cerrados.
                    Los procesos se editan desde cada cargo individualmente.
                </small></i></p>
        {{--
        @if(isset($comision))
            <a href="{{route('excel.procesosModular',['materia_id'=>$materia->id,'comision_id'=>$comision->id])}}"
               class="btn btn-sm btn-success"><i class="fas fa-download"></i> Descargar planilla</a>
        @else
            <a href="{{route('excel.procesosModular',['materia_id'=>$materia->id])}}" class="btn btn-sm btn-success"><i
                        class="fas fa-download"></i> Descargar
                planilla</a>
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
                <a href="{{route('proceso_modular.procesa_estados_modular',['materia'=>$materia->id, 'cargo_id' => $cargo_id])}}"
                   class="btn btn-sm btn-info">Calcula Regularidad</a>
            @endif
        @endif

        @if(count($procesos) > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="job-table">
                    <thead class="thead-dark text-white" style="z-index: 100">
                    <tr class="fijar">
                        <th class="sticky-top">
                            Alumno
                        </th>
                        <th class="sticky-top">Prom. Final %</th>
                        <th class="sticky-top">Prom. Final #</th>
                        <th class="sticky-top">Asis. Final %</th>
                        <th class="sticky-top">TFI %</th>
                        <th class="sticky-top">TFI #</th>
                        <th class="sticky-top">Nota Final %</th>
                        <th class="sticky-top">Nota Final #</th>
                        <th class="sticky-top col-sm-1">Global #</th>
                        <th class="sticky-top">Cierre <br/>
                            {{--        <a href="{{ route('proceso.cambiaCierreGeneral', ['materia_id'=> $materia->id, 'cargo_id'=> $cargo->id]) }}"--}}
                            {{--           class="btn btn-warning">--}}
                            {{--            Cerrar Notas {{ $cargo->nombre }} @if($comision)<br/><small>{{$comision->nombre}}</small>@endif--}}
                            {{--        </a>--}}
                        </th>
                        {{--                        <th><a href="{{ route('asis.inicio') }}" class="text-white"> Asistencia % </a></th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($procesos as $proceso)
                        <tr class="bg-secondary text-white font-weight-bold">
                            <td>
                                {{$proceso->procesoRelacionado->alumno->apellidos_nombres}}
                                <small><br/>
                                    <select name="estado" id="estado" class="custom-select custom-select-sm estados"
                                    @if(!$puede_procesar || $proceso->procesoRelacionado->cierre) disabled=disabled @endif

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

                                </small>

                            </td>
                            <td class="text-center">
                                {{number_format($proceso->promedio_final_porcentaje, 2, '.', ',')}} %|
                            </td>

                            <td class="text-center">
                                {{$proceso->promedio_final_nota}} |
                            </td>
                            <td class="text-center">
                                {{$proceso->asistencia_final_porcentaje}} % |
                            </td>
                            <td class="text-center">
                                {{$proceso->trabajo_final_porcentaje}} %|
                            </td>
                            <td class="text-center">
                                {{$proceso->trabajo_final_porcentaje}} %|
                            </td>
                            <td class="text-center">
                                {{$proceso->nota_final_porcentaje}} %|
                            </td>
                            <td class="text-center">
                                {{$proceso->nota_final_nota}} |
                            </td>
                            <td class="row">
                                <form action="" id="{{ $proceso->procesoRelacionado->id }}" class="form_nota_global">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                               class="form-control nota_global {{ $proceso->procesoRelacionado->nota_global >= 4 ? 'text-success' : '' }} {{ $proceso->procesoRelacionado->nota_global < 4 ? 'text-danger' : '' }}"
                                               id="global-{{ $proceso->procesoRelacionado->id }}"
                                               value="{{ $proceso->procesoRelacionado->nota_global != -1 ? $proceso->procesoRelacionado->nota_global : 'A' }}"
                                               @if(($proceso->procesoRelacionado->estado && $proceso->procesoRelacionado->estado->identificador != 5) ||   !$puede_procesar || $proceso->procesoRelacionado->cierre) disabled @endif>
                                        <div class="input-group-append">
                                            <button type="submit"
                                                    class="btn btn-info btn-sm input-group-text"
                                                    id="btn-global-{{ $proceso->procesoRelacionado->id }}"
                                                    @if(!Session::has('profesor') or $proceso->procesoRelacionado->cierre) disabled @endif>
                                                <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                </form>
                            </td>
                            <td>
    <span class="d-none" id="span-{{$proceso->procesoRelacionado->id}}">
        <small style="font-size: 0.6em" class="text-success">Cambio realizado</small>
    </span>
                                <span class="d-none" id="spin-{{$proceso->procesoRelacionado->id}}">
        <i class="fa fa-spinner fa-spin"></i>
    </span>

                                <input type="checkbox" class="check-cierre"
                                       id="{{$proceso->procesoRelacionado->id}}" {{!$proceso->procesoRelacionado->cierre ? 'unchecked':'checked'}} />
                            </td>


                        </tr>
                        <tr>
                            <td colspan="9" class="border-top-0 border-info">
                                @include('proceso.listado-cargos-modulo', ['alumno' => $proceso->procesoRelacionado->alumno, 'cargos' => $materia->cargos ])
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
                <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>

@endsection
