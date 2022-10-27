@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Preinscripciones eliminadas
    </h2>
    <hr>
    @if(count($preinscripciones) == 0)
    <p>No hay preinscripciones eliminadas</p>
    @else
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre y Apellido</th>
                <th scope="col">D.N.I</th>
                <th scope="col">Carrera</th>
                <th scope="col">Responsable</th>
                <th scope="col">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($preinscripciones as $preinscripcion)
            <tr style="cursor:pointer;">
                <td>{{ $preinscripcion->nombres.' '.$preinscripcion->apellidos }}</td>
                <td>{{ $preinscripcion->dni }}</td>
                <td>{{ $preinscripcion->carrera->nombre }}</td>
                <td>{{ $preinscripcion->responsable_delete }}</td>
                <td>{{date_format(new DateTime($preinscripcion->deleted_at),'d-m-Y H:i')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</div>

@endsection