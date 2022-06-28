@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1 text-info">
            Notas de Proceso de {{ $materia->nombre }} @if($comision)
                <br/><small>{{$comision->nombre}}</small>
            @endif
        </h2>
        <hr>
        @if(count($procesos) > 0)
            <div class="table-responsive">

                <table class="table mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <td>
                            Alumno
                        </td>
                        @if(count($calificaciones) > 0)
                            @foreach($calificaciones as $calificacion)
                                <td>{{$calificacion->nombre}}</td>
                            @endforeach
                        @else
                            <td>
                                Notas
                            </td>
                        @endif
                        <td>
                            Estado
                        </td>
                        <td>
                            Cierre
                        </td>
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
                                        {{$proceso->procesoCalificacion($cc->id)->porcentaje}}
                                        @else
                                            -
                                        @endif
                                        %
                                    </td>

{{--                                                                        <td>{{$calificacion->nombre}}</td>--}}


{{--                                    @if($proceso->procesosCalificaciones())--}}
{{--                                        @foreach($proceso->procesosCalificaciones() as $calificacion)--}}
{{--                                            <td>--}}
{{--                                            {{$calificacion->id}} ({{$calificacion->nombre}})--}}
{{--                                                / {{$cc->id}}({{$cc->nombre}}) /--}}

{{--                                            @if($calificacion->id == $cc->id)--}}

{{--                                                    {{$calificacion->porcentaje}}--}}

{{--                                            @endif--}}
{{--                                            </td>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
                                @endforeach
                            @else
                                <td>
                                    -
                                </td>
                            @endif

                            <td>

                                <select class="custom-select select-estado" name="estado-{{$proceso->id}}"
                                        id="{{$proceso->id}}">
                                    <option value="">Seleccione estado</option>
                                    @foreach($estados as $estado)
                                        @if($estado->id == $proceso->estado_id)
                                            <option value="{{$estado->id}}"
                                                    selected>{{$estado->nombre}}</option>
                                        @else
                                            <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <span class="d-none" id="span-{{$proceso->id}}">
									<small style="font-size: 0.6em" class="text-success">Cambio realizado</small>
								</span>
                                <span class="d-none" id="spin-{{$proceso->id}}">
									<i class="fa fa-spinner fa-spin"></i>
								</span>

                                <input type="checkbox" class="check-cierre" id="{{$proceso->id}}"
                                        {{$proceso->cierre == false ? 'unchecked':'checked'}}>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                    @else
                        'No se encontraron procesos'
                @endif
                {{--		<div class="col-md-4 m-0 p-0 proceso-detalle">--}}
                {{--			<ul>--}}
                {{--				<li><strong>Materia:</strong> {{ $proceso->materia->nombre }}</li>--}}
                {{--				<li><strong>Estado:</strong> {{ ucwords($proceso->estado) }}</li>--}}
                {{--				<li><strong>Nota final de parciales:</strong>--}}
                {{--				 {{ $proceso->final_parciales ? $proceso->final_parciales : 'Sin asignar'}}--}}
                {{--				</li>--}}
                {{--				<li><strong>Nota final de TP:</strong>--}}
                {{--					{{ $proceso->final_trabajos ? $proceso->final_trabajos : 'Sin asignar'}}--}}
                {{--				</li>--}}
                {{--				<li><strong>Asistencia final:</strong>--}}
                {{--					{{ $proceso->final_asistencia ? $proceso->final_asistencia : 'Sin asignar'}}--}}
                {{--				</li>--}}
                {{--			</ul>--}}
                {{--		</div>--}}
            </div>
            @endsection
            @section('scripts')
                <script src="{{ asset('js/proceso/cambia_estado.js') }}"></script>
                <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>
@endsection