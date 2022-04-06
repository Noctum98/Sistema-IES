@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1">Usuario {{ $user->nombre.' '.$user->apellido }}</h2>
    <hr>
    <div class="row col-md-12">
        <div class="col-md-6">
            <h5>Datos</h5>

            <ul class="m-0 p-0">
                <li><strong>Nombre:</strong> {{ $user->nombre }} </li>
                <li><strong>Apellido:</strong> {{ $user->apellido }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Teléfono:</strong> {{ $user->telefono }}</li>
                <li><strong>Username:</strong> {{ $user->username }}</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h5>Carreras</h5>
            <ul class="m-0 p-0">
                @foreach($user->carreras as $carrera)
                <li>{{ $carrera->nombre.' - '.$carrera->sede->nombre }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12 mt-3">
            <h5>Materias</h5>
            <ul class="m-0 p-0">
                @foreach($user->materias as $materia)
                <li>
                    {{ $materia->nombre.' - '.$materia->carrera->nombre.' - '.$materia->carrera->sede->nombre }} -
                    <a href="" class="text-danger">Eliminar</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
@endsection