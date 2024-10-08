@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <a href="{{url()->previous()}}">
                    <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
                </a>
                @if($calificacion->cargo_id)
                    <br/>
                    <a href="{{route('proceso.listadoCargo', [
                        'materia_id' => $calificacion->materia->id,
                        'cargo_id' => $calificacion->cargo_id
                    ])}}">
                        <button class="btn btn-outline-success">
                            <i class="fas fa-angle-left"></i>
                            Ver planilla cargo
                        </button>
                    </a>
                @endif

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
                            <br/>
                            @if($calificacion->modelCargo()->first()->profesores())
                                <small style="font-size: 0.8em" class="text-muted">
                                    {{$calificacion->modelCargo()->first()->profesores()}}
                                </small>
                            @endif
                        @endif
                        @if($calificacion->comision)
                            <br/>
                            <h4> Comisión: {{$calificacion->comision->nombre}}</h4>
                        @endif
                        <h6>
                            Ciclo lectivo: {{$calificacion->ciclo_lectivo}}
                        </h6>
                    </div>
                    <div class="col-sm-8">
                        <h4 class="text-dark">
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
                        <td class="py-auto">
                            {{ mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->nombres) }}
                        </td>
                        <td class="py-auto">
                            @if(!$proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo))
                                <form action=""
                                      class="col-md-6 m-0 p-0 calificacion-alumnos form-calificacion input-group"
                                      id="{{ $proceso->id }}" method="POST">
                                    <input type="hidden" name="calificacion_id" id="calificacion_id"
                                           value="{{ $calificacion->id }}">
                                    <input type="hidden" name="ciclo_lectivo" id="ciclo_lectivo"
                                           value="{{ $calificacion->ciclo_lectivo }}">
                                    <div class="input-group my-0">
                                        <input type="text" class="form-control datablur"
                                               id="calificacion-procentaje-{{ $proceso->id }}"
                                               value="{{ $proceso->procesoCalificacion($calificacion->id) && $proceso->procesoCalificacion($calificacion->id)->porcentaje != -1  ? $proceso->procesoCalificacion($calificacion->id)->porcentaje : '' }} {{ $proceso->procesoCalificacion($calificacion->id) && $proceso->procesoCalificacion($calificacion->id)->porcentaje == -1  ? 'A' : '' }}"
                                               placeholder="%"

                                               @if(!Auth::user()->hasMateria($proceso->materia_id)
                                                    && !Auth::user()->hasCargo(optional($calificacion->modelCargo()->first())->id)
                                                    )
                                                   disabled
                                               @endif

                                               @if(!Session::has('profesor') || $proceso->cierre == 1)
                                                   disabled
                                            @endif
                                        >
                                        <div class="input-group-append">
                                            <button type="submit"
                                                    class="btn btn-info btn-sm  input-group-text
                                                    @if(!Session::has('profesor')
                                                        or $proceso->cierre == 1 )
                                                        disabled
                                                   @endif
                                                   ">
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
                                    @include('componentes.colorNotas', ['nota' => $proceso->procesoCalificacion($calificacion->id)->nota, 'year' => $calificacion->ciclo_lectivo])
                                @endif
                            @else
                            @endif

                        </td>
                        @if($calificacion->tipo->descripcion == 1)
                            <td>

                                @if(!$proceso->alumno()->first()->hasEquivalenciaMateriaCicloLectivo($calificacion->materia->id,$calificacion->ciclo_lectivo))
                                <form action="" class="col-md-6 m-0 p-0 calificacion-alumnos form-recuperatorio"
                                      id="{{ $proceso->id }}"
                                      method="POST">
                                    <input type="hidden" name="calificacion_id" id="calificacion_id"
                                           value="{{ $calificacion->id }}">
                                    <input type="hidden" name="ciclo_lectivo" id="ciclo_lectivo"
                                           value="{{ $calificacion->ciclo_lectivo }}">
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control datablur"
                                               id="calificacion-procentaje-recuperatorio-{{ $proceso->id }}"
                                               value="{{ $proceso->procesoCalificacion($calificacion->id)&& $proceso->procesoCalificacion($calificacion->id)->porcentaje_recuperatorio ? $proceso->procesoCalificacion($calificacion->id)->porcentaje_recuperatorio : '' }}"
                                               placeholder="%"

                                               @if(!Auth::user()->hasMateria($proceso->materia_id))
                                                   disabled
                                               @endif

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
                                @endif
                            </td>


                            <td class="nota-recuperatorio-{{ $proceso->id }}">
                                @if($proceso->procesoCalificacion($calificacion->id) && $proceso->procesoCalificacion($calificacion->id)->nota_recuperatorio)
                                    @include('componentes.colorNotas', ['nota' => $proceso->procesoCalificacion($calificacion->id)->nota_recuperatorio, 'year' => $calificacion->ciclo_lectivo])
                                @endif
                            </td>
                        @endif
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
