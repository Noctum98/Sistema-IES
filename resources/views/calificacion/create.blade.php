@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <a href="{{url()->previous()}}" ><button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button> </a>

    <h2 class="h1 text-info">
        {{ $calificacion->nombre.' - '.$calificacion->materia->nombre }}
    </h2>
    <hr>
    <div id="alerts">

    </div>
    <div class="col-md-12">
        <table class="table">
            <thead class="thead-dark">
                <th>Apellido y Nombre</th>
               
                <th>Porcentaje %</th>
                <th>Nota</th>
            </thead>
            <tbody>
                @foreach($procesos as $proceso)
                <tr>
                    <td>
                        {{ $proceso->alumno->apellidos.' '.$proceso->alumno->nombres }}
                    </td>
                    
                    <td>
                        <form action="" class="col-md-3 m0 p-0 calificacion-alumnos form-calificacion" id="{{ $proceso->id }}" method="POST">
                            <input type="hidden" name="calificacion_id" id="calificacion_id" value="{{ $calificacion->id }}">
                           
                            <input type="number" class="form-control col-md-5" id="calificacion-procentaje-{{ $proceso->id }}" value="{{ $proceso->procesoCalificacion($calificacion->id) ? $proceso->procesoCalificacion($calificacion->id)->porcentaje : '' }}" placeholder="%" required>

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