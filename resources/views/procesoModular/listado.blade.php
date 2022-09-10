@extends('layouts.app-prueba')
@section('content')
    <style>
        table {
            font-size: 0.85em;
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

        @if(isset($comision))
            <a href="{{route('excel.procesosModular',['materia_id'=>$materia->id,'comision_id'=>$comision->id])}}"
               class="btn btn-sm btn-success">Descargar planilla</a>
        @else
            <a href="{{route('excel.procesosModular',['materia_id'=>$materia->id])}}" class="btn btn-sm btn-success">Descargar
                planilla</a>

        @endif
        @if($cargo_id)
            @inject('cargoService', 'App\Services\CargoService')
            {{--            @if($cargoService->getResponsableTFI($cargo_id, $materia->id) == 1)--}}
            @if($puede_procesar)
                <a href="{{route('proceso_modular.procesa_estados_modular',['materia'=>$materia->id, 'cargo_id' => $cargo_id])}}"
                   class="btn btn-sm btn-info">Calcula Regularidad</a>
            @endif
        @endif

        @if(count($procesos) > 0)
            <div class="table tableFixHead">
                <table class="table mt-1 ">
                    <thead class="thead-dark text-white ">
                    <tr>
                        <th>
                            Alumno
                        </th>
                        <th>Prom. Final %</th>
                        <th>Prom. Final #</th>
                        <th>Asis. Final %</th>
                        <th>TFI %</th>
                        <th>TFI #</th>
                        <th>Nota Final %</th>
                        <th>Nota Final #</th>
                        <th class="col-sm-1">Global #</th>
                        <th>Cierre</th>
                        {{--                        <th><a href="{{ route('asis.inicio') }}" class="text-white"> Asistencia % </a></th>--}}

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($procesos as $proceso)
                        <tr class="bg-secondary text-white font-weight-bold">
                            <td>
                                {{$proceso->procesoRelacionado->alumno->apellidos_nombres}}
                                <small><br/>{{optional($proceso->procesoRelacionado->estado)->nombre}}</small>
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
                            <td>
                                <form action="" id="{{ $proceso->procesoRelacionado->id }}" class="form_nota_global">
                                    <input type="number"
                                           class="form-control nota_global {{ $proceso->procesoRelacionado->nota_global >= 4 ? 'text-success' : '' }} {{ $proceso->procesoRelacionado->nota_global < 4 ? 'text-danger' : '' }}"
                                           id="global-{{ $proceso->procesoRelacionado->id }}"
                                           value="{{ $proceso->procesoRelacionado->nota_global ? $proceso->procesoRelacionado->nota_global : '' }}"
                                           @if(($proceso->procesoRelacionado->estado && $proceso->procesoRelacionado->estado->identificador != 5) ||   !$puede_procesar || $proceso->procesoRelacionado->cierre) disabled @endif>
                                    <button type="submit" class="btn btn-info btn-sm col-md-6 input-group-text"
                                            id="btn-global-{{ $proceso->procesoRelacionado->id }}"
                                            @if(!Session::has('profesor') or $proceso->procesoRelacionado->cierre) disabled @endif>
                                        <i class="fa fa-save"></i></button>
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
                                       id="{{$proceso->procesoRelacionado->id}}" {{$proceso->procesoRelacionado->cierre == false ? 'unchecked':'checked'}} />
                            </td>

                            {{--                            <td>--}}
                            {{--                                {{ $proceso->asistencia() ? $proceso->asistencia()->porcentaje_final : '-' }} |  %--}}
                            {{--                            </td>--}}


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
                {{--                <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>--}}
                <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>
@endsection