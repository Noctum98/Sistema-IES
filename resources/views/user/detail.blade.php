@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">Usuario {{ $user->nombre.' '.$user->apellido }}</h2>
    <hr>
    <div class="row col-md-12">
        <div class="col-md-6">
            <h5 class="text-secondary">Datos</h5>

            <ul class="m-0 p-0">
                <li><strong>Nombre:</strong> {{ $user->nombre }} </li>
                <li><strong>Apellido:</strong> {{ $user->apellido }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Teléfono:</strong> {{ $user->telefono }}</li>
                <li><strong>Username:</strong> {{ $user->username }}</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h5 class="text-secondary">Carreras</h5>
            <ul class="m-0 p-0">
                @foreach($user->carreras as $carrera)
                <li>{{ $carrera->nombre.' - '.$carrera->sede->nombre }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12 mt-3">
            <h5 class="text-secondary">Materias</h5>
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
        <div class="colmd-12 mt-3">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#rolesModal{{$user->id}}">
                Asignar Roles
            </button>
            <button type="button" class="ml-2 btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$user->id}}">
                Asignar Sedes
            </button>
            <button type="button" class="ml-2 btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#materiasModal{{$user->id}}">
                Asignar Carreras/Materias
            </button>
            <button type="button" class="ml-2 btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#cargosModal{{$user->id}}">
                Asignar Carreras/Cargos
            </button>
            @include('user.modals.admin_sedes')
            @include('user.modals.admin_roles')
            @include('user.modals.admin_carreras_materias')
            @include('user.modals.admin_carreras_cargos')
        </div>
    </div>

</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/user/carreras.js') }}"></script>
    <script src="{{ asset('js/user/cargos.js') }}"></script>
@endsection
