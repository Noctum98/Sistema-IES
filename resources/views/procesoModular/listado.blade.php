@extends('layouts.app-prueba')
@section('content')
    <style>
        table {
            font-size: 0.85em;
        }
    </style>
    <div class="container-fluid w-100" id="container-scroll">
        <a href="{{route('calificacion.admin', ['materia_id'=>$materia->id, 'cargo_id'=> $cargo_id])}}">
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


        {{--    <a href="{{ route('excel.procesos',['materia_id'=>$materia->id]) }}" class="btn btn-sm btn-success">Descargar Planilla</a>--}}

        @if(count($procesos) > 0)
            <div class="table tableFixHead">
                <table class="table mt-1 ">
                    <thead class="thead-dark ">
                    <tr>
                        <th>
                            Alumno
                        </th>
                        <th>Promedio Final %</th>
                        <th>Promedio Final #</th>
                        <th>Trabajo FI %</th>
                        <th>Trabajo FI #</th>
                        <th>Nota Final %</th>
                        <th>Nota Final #</th>
                        <th>Cierre</th>
                        {{--                        <th><a href="{{ route('asis.inicio') }}" class="text-white"> Asistencia % </a></th>--}}

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($procesos as $proceso)
                        <tr class="bg-secondary">
                            <td>
                                {{$proceso->procesoRelacionado->alumno->apellidos_nombres}}
                            </td>
                            <td class="text-center">
                                {{number_format($proceso->promedio_final_porcentaje, 2, '.', ',')}} %|
                            </td>
                            <td class="text-center">
                                {{$proceso->promedio_final_nota}} |
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
                                <span class="d-none" id="span-{{$proceso->id}}">
                                    <small style="font-size: 0.6em" class="text-success">
                                        Cambio realizado
                                    </small>
                                </span>
                                <span class="d-none" id="spin-{{$proceso->id}}">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </span>

                                <input type="checkbox" class="check-cierre"
                                       id="{{$proceso->id}}" {{$proceso->cierre == false ? 'unchecked':'checked'}}>
                            </td>


                            {{--                            <td>--}}
                            {{--                                {{ $proceso->asistencia() ? $proceso->asistencia()->porcentaje_final : '-' }} |  %--}}
                            {{--                            </td>--}}


                        </tr>
                        <tr>
                            <td colspan="8" class="border-top-0 border-info">
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
    {{--                <script src="{{ asset('js/proceso/cambia_nota.js') }}"></script>--}}
@endsection