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
                <li class="mt-3">
                    {{ $materia->nombre.' - '.$materia->carrera->nombre.' - '.$materia->carrera->sede->nombre }} -
                    <form action="{{ route('delete_materias_carreras',['user_id'=> $user->id,'materia_id'=>$materia->id]) }}" method="POST" class="d-inline">
                        {{ method_field('DELETE') }}
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>

                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
@endsection