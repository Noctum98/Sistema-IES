@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
        </a>
        <h3 class="text-info">
            {{ $calificacion->nombre.' - '.$calificacion->materia->nombre}} <small>{{$calificacion->tipo()->first()->nombre}}</small>
            @if($calificacion->comision)
                <h4> Comisión: {{$calificacion->comision->nombre}}</h4>
            @endif
            @if($calificacion->modelCargo()->first())
                <h4>Cargo: {{$calificacion->modelCargo()->first()->nombre}}</h4>
            @endif
            @if($calificacion->modelCargo()->first())
                <h4>Cargo: {{$calificacion->modelCargo()->first()->nombre}}</h4>
            @endif

        </h3>
        <hr>
        <p><i>Recordatorio: Para guardar la nota de cada alumno, pulse enter o el botón de guardar debajo de cada
                recuadro.</i></p>
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
                    <tr>
                        <td>
                            {{ mb_strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->nombres) }}
                        </td>
                        <td class="input-group">
                            <form action="" class="col-md-6 m-0 p-0 calificacion-alumnos form-calificacion input-group"
                                  id="{{ $proceso->id }}" method="POST">
                                <input type="hidden" name="calificacion_id" id="calificacion_id"
                                       value="{{ $calificacion->id }}">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                           id="calificacion-procentaje-{{ $proceso->id }}"
                                           value="{{ $proceso->procesoCalificacion($calificacion->id) && $proceso->procesoCalificacion($calificacion->id)->porcentaje != -1  ? $proceso->procesoCalificacion($calificacion->id)->porcentaje : '' }} {{ $proceso->procesoCalificacion($calificacion->id) && $proceso->procesoCalificacion($calificacion->id)->porcentaje == -1  ? 'A' : '' }}"
                                           placeholder="%"
                                           @if(!Session::has('profesor') or $proceso->cierre == 1  or Auth::user()->id != $calificacion->user_id or
                                    optional(optional($calificacion->modelCargo()->first())->obtenerProcesoCargo($proceso->id))->isClose())
                                           disabled
                                            @endif>
                                    <div class="input-group-append">
                                        <button type="submit"
                                                class="btn btn-info btn-sm  input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">
                                            <i class="fa fa-save"></i></button>
                                    </div>
                                </div>
                                <div id="spinner-{{$proceso->id}}">
                                </div>
                            </div>
                            <div id="spinner-{{$proceso->id}}">
                            </div>
                        </form>

                    </td>
                    <td class="nota-{{ $proceso->id }}">
                        @if($proceso->procesoCalificacion($calificacion->id))
                        @if($proceso->procesoCalificacion($calificacion->id)->nota >= 4)
                        <p class='text-success font-weight-bold'>{{ $proceso->procesoCalificacion($calificacion->id)->nota }} </p>
                        @elseif($proceso->procesoCalificacion($calificacion->id)->nota < 4 && $proceso->procesoCalificacion($calificacion->id)->nota >= 0)
                            <p class='text-danger font-weight-bold'>{{ $proceso->procesoCalificacion($calificacion->id)->nota }}</p>
                            @else
                            <p class='text-danger font-weight-bold'>A</p>
                            @endif
                            @endif
                    </td>
                    @if($calificacion->tipo->descripcion == 1)

                    <td>
                        <form action="" class="col-md-6 m-0 p-0 calificacion-alumnos form-recuperatorio" id="{{ $proceso->id }}" method="POST">
                            <input type="hidden" name="calificacion_id" id="calificacion_id" value="{{ $calificacion->id }}">
                            <input type="text" style="width: 100%" class="form-control col-md-12" id="calificacion-procentaje-recuperatorio-{{ $proceso->id }}" value="{{ $proceso->procesoCalificacion($calificacion->id)&& $proceso->procesoCalificacion($calificacion->id)->porcentaje_recuperatorio ? $proceso->procesoCalificacion($calificacion->id)->porcentaje_recuperatorio : '' }}" placeholder="%" @if(!Session::has('profesor') || !$proceso->procesoCalificacion($calificacion->id) || $proceso->cierre) disabled
                            @endif>
                            <button type="submit" class="btn btn-info btn-sm col-md-12 input-group-text
                                            @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif">
                                <i class="fa fa-save"></i></button>

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

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/calificacion/crear.js') }}"></script>
@endsection