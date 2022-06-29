@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <a href="{{url()->previous()}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>

    <h2 class="h1 text-info">
        {{ $calificacion->nombre.' - '.$calificacion->materia->nombre}}
        @if($calificacion->comision)
        {{$calificacion->comision->nombre}}
        @endif
    </h2>
    <hr>
    <p><i>Recordatorio: Para guardar la nota de cada alumno, pulse enter o el boton de guardar debajo de cada recuadro.</i></p>
    <div id="alerts">

    </div>
    <div class="col-md-12">
        <table class="table col-md-12 m-0 p-0">
            <thead class="thead-dark">
                <th>Apellido y Nombre</th>

                <th>Porcentaje %</th>


                <th>Nota</th>

                @if($calificacion->tipo->descripcion == 1)
                <th>Porcentaje Recuperatorio %</th>

                <th>Nota Recuperatorio</th>
                @endif

            </thead>
            <tbody>
                @foreach($procesos as $proceso)
                <tr>
                    <td>
                        {{ strtoupper($proceso->alumno->apellidos).' '.ucwords($proceso->alumno->nombres) }}

                    </td>
                    <td class="input-group">
                        <form action="" class="col-md-3 m0 p-0 calificacion-alumnos form-calificacion input-group" id="{{ $proceso->id }}" method="POST">
                            <input type="hidden" name="calificacion_id" id="calificacion_id" value="{{ $calificacion->id }}">

                            @if($calificacion->tipo->descripcion == 1)
                            <input type="text" style="width: 100%" class="form-control col-md-12" id="calificacion-procentaje-{{ $proceso->id }}" value="{{ $proceso->procesoCalificacion($calificacion->id) ? $proceso->procesoCalificacion($calificacion->id)->porcentaje : '' }}" placeholder="%" @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif required>
                            @else
                            <input type="number" style="width: 100%" class="form-control col-md-12 " id="calificacion-procentaje-{{ $proceso->id }}" value="{{ $proceso->procesoCalificacion($calificacion->id) ? $proceso->procesoCalificacion($calificacion->id)->porcentaje : '' }}" placeholder="%" @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif required>
                            @endif
                            <button type="submit" class="btn btn-info btn-sm col-md-12 input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif"><i class="fa fa-save"></i> </button>

                            <div id="spinner-{{$proceso->id}}">

                            </div>
                        </form>
                    </td>
                    <td class="nota-{{ $proceso->id }}">
                        @if($proceso->procesoCalificacion($calificacion->id))
                        @if($proceso->procesoCalificacion($calificacion->id)->nota >= 4)
                        <p class='text-success font-weight-bold'>{{ $proceso->procesoCalificacion($calificacion->id)->nota }} </p>
                        @else
                        <p class='text-danger font-weight-bold'>{{ $proceso->procesoCalificacion($calificacion->id)->nota }}</p>
                        @endif
                        @endif
                    </td>
                    @if($calificacion->tipo->descripcion == 1)
                    <td>
                        <form action="" class="col-md-3 m0 p-0 calificacion-alumnos form-recuperatorio" id="{{ $proceso->id }}" method="POST">
                            <input type="hidden" name="calificacion_id" id="calificacion_id" value="{{ $calificacion->id }}">
                            <input type="text" style="width: 100%" class="form-control col-md-12" id="calificacion-procentaje-recuperatorio-{{ $proceso->id }}" value="{{ $proceso->procesoCalificacion($calificacion->id)&& $proceso->procesoCalificacion($calificacion->id)->nota_recuperatorio ? $proceso->procesoCalificacion($calificacion->id)->nota_recuperatorio : '' }}" placeholder="%" @if(!Session::has('profesor') || !$proceso->procesoCalificacion($calificacion->id)) || $proceso->cierre disabled @endif required>
                            <button type="submit" class="btn btn-info btn-sm col-md-12 input-group-text @if(!Session::has('profesor') or $proceso->cierre == 1 ) disabled @endif"><i class="fa fa-save"></i> </button>

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


