@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <a href="{{url()->previous()}}">
                    <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
                </a>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>
                            @if(Auth::user()->hasRole('admin'))
                                <small>id: {{$calificacion->materia->id}} </small>
                            @endif
                            {{ $calificacion->materia->nombre}}</h5>
                        @if($calificacion->modelCargo()->first())
                            Cargo: <b><i>{{$calificacion->modelCargo()->first()->nombre}}</i></b>
                        @endif
                        @if($calificacion->comision)
                            <br/>
                            <h4> Comisión: {{$calificacion->comision->nombre}}</h4>
                        @endif
                        <h6>Ciclo lectivo: {{$calificacion->ciclo_lectivo}}</h6>
                    </div>
                    <div class="col-sm-8">
                        <h4 class="text-info">
                            {{ $calificacion->nombre}}
                            <br/>
                            <small>{{$calificacion->tipo()->first()->nombre}}</small>
                            <br/>
                            <small>{{$calificacion->description}}</small>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <p><i>Recordatorio: Para guardar la nota de cada alumno, pulse enter o el botón de guardar de cada
                porcentaje.</i></p>
        <div id="alerts">

        </div>
        <div class="col-md-12">
            <table class="table col-md-12 m-0 p-0">
                <thead class="thead-dark">
                <th style="width: 40%">Apellido y Nombre</th>

                <th style="width: 20%">Porcentaje %</th>


                <th style="width: 10%">Nota</th>

                @if($calificacion->tipo->descripcion == 1)
                    <th style="width: 20%">Porcentaje Recuperatorio %</th>

                    <th style="width: 10%">Nota Recuperatorio</th>
                @endif

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
                            {{ mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->nombres) }}
                        </td>
                        <td class="py-auto">
                            @if(!$proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo))
                                <form action=""
                                      class="col-md-6 m-0 p-0 calificacion-alumnos form-calificacion input-group"
                                      id="{{ $proceso->id }}" method="POST">
                                    <input type="hidden" name="calificacion_id" id="calificacion_id"
                                           value="{{ $calificacion->id }}">
                                    <div class="input-group my-0">
                                        <input type="text" class="form-control"
                                               id="calificacion-procentaje-{{ $proceso->id }}"
                                               value="{{ $proceso->procesoCalificacion($calificacion->id) && $proceso->procesoCalificacion($calificacion->id)->porcentaje != -1  ? $proceso->procesoCalificacion($calificacion->id)->porcentaje : '' }} {{ $proceso->procesoCalificacion($calificacion->id) && $proceso->procesoCalificacion($calificacion->id)->porcentaje == -1  ? 'A' : '' }}"
                                               placeholder="%"
                                               @if(!Session::has('profesor') or $proceso->cierre == 1  or Auth::user()->id != $calificacion->user_id or
                                                optional($proceso->procesoCalificacion($calificacion->id))->close == 1 or optional(optional($calificacion->modelCargo()->first())->obtenerProcesoCargo($proceso->id))->isClose())
                                                   disabled
                                            @endif >
                                        <div class="input-group-append">
                                            <button type="submit"
                                                    class="btn btn-info btn-sm  input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">
                                                <i class="fa fa-save"></i></button>
                                        </div>
                                    </div>
                                    <div id="spinner-{{$proceso->id}}">
                                    </div>
                                </form>
                            @endif

                        </td>
                        <td class="nota-{{ $proceso->id }}">
                            @if(!$proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo))
                                @if($proceso->procesoCalificacion($calificacion->id))
                                    @if($proceso->procesoCalificacion($calificacion->id)->nota >= 4)
                                        <p class='text-success font-weight-bold'>{{ $proceso->procesoCalificacion($calificacion->id)->nota }} </p>
                                    @elseif($proceso->procesoCalificacion($calificacion->id)->nota < 4 && $proceso->procesoCalificacion($calificacion->id)->nota >= 0)
                                        <p class='text-danger font-weight-bold'>{{ $proceso->procesoCalificacion($calificacion->id)->nota }}</p>
                                    @else
                                        <p class='text-danger font-weight-bold'>A</p>
                                    @endif
                                @endif
                            @else
                                {{$proceso->alumno()->first()->getNotaEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo)}}
                            @endif

                        </td>
                        @if($calificacion->tipo->descripcion == 1)

                            <td>
                                <form action="" class="col-md-6 m-0 p-0 calificacion-alumnos form-recuperatorio"
                                      id="{{ $proceso->id }}"
                                      method="POST">
                                    <input type="hidden" name="calificacion_id" id="calificacion_id"
                                           value="{{ $calificacion->id }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               id="calificacion-procentaje-recuperatorio-{{ $proceso->id }}"
                                               value="{{ $proceso->procesoCalificacion($calificacion->id)&& $proceso->procesoCalificacion($calificacion->id)->porcentaje_recuperatorio ? $proceso->procesoCalificacion($calificacion->id)->porcentaje_recuperatorio : '' }}"
                                               placeholder="%"
                                               @if(!Session::has('profesor') || !$proceso->procesoCalificacion($calificacion->id) || $proceso->cierre) disabled @endif
                                        >

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-info btn-sm input-group-text
                                            @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">
                                                <i class="fa fa-save"></i></button>
                                        </div>
                                    </div>

                                    <div id="spinner-recuperatorio-{{$proceso->id}}">
                                    </div>
                                </form>
                            </td>


                            <td class="nota-recuperatorio-{{ $proceso->id }}">
                                @if($proceso->procesoCalificacion($calificacion->id) && $proceso->procesoCalificacion($calificacion->id)->nota_recuperatorio)
                                    @if($proceso->procesoCalificacion($calificacion->id)->nota_recuperatorio >= 4)
                                        <p class='text-success font-weight-bold'>{{ $proceso->procesoCalificacion($calificacion->id)->nota_recuperatorio }} </p>
                                    @else
                                        <p class='text-danger font-weight-bold'>{{ $proceso->procesoCalificacion($calificacion->id)->nota_recuperatorio }}</p>
                                    @endif
                                @endif
                            </td>
                        @endif
                        {{--                        <td>--}}
                        {{--                        <input type="checkbox" class="check-cierre" id="check-{{$proceso->id}}" {{$proceso->procesoCalificacion($calificacion->id)->cierre == false ? 'unchecked':'checked'}}--}}
                        {{--                                {{ $proceso->cierre && (!Session::has('coordinador') or !Session::has('profesor') ) ? 'disabled' : '' }}--}}
                        {{--                        />--}}
                        {{--                        </td>--}}

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/calificacion/crear.js') }}"></script>
    {{--    <script src="{{ asset('js/proceso/cambia_cierre.js') }}"></script>--}}
@endsection
