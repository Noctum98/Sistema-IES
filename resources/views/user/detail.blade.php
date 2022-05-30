@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">Usuario {{ $user->nombre.' '.$user->apellido }}</h2>
    <hr>
    @if(@session('carrera_success'))
    <div class="alert alert-success">
        {{ @session('carrera_success') }}
    </div>
    @endif
    @if(@session('error_sede'))
    <div class="alert alert-warning">
        {{ @session('error_sede') }}
    </div>
    @endif
    @if(@session('error_rol'))
    <div class="alert alert-danger">
        {{ @session('error_rol') }}
    </div>
    @elseif(@session('message'))
    <div class="alert alert-success">
        {{ @session('message') }}
    </div>
    @endif
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
                @if(count($user->carreras) > 0)
                @foreach($user->carreras as $carrera)
                <li>
                    {{ $carrera->nombre.' ( '.$carrera->resolucion.' '.$carrera->turno.' ) '.' - '.$sede->nombre }}
                    -
                    <form action="{{ route('delete_user_carrera',$user->id) }}" method="POST" class="d-inline">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="carrera_id" value="{{ $carrera->id }}">
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>
                </li>
                @endforeach
                @else
                <p>No hay carreras vinculadas al usuario.</p>
                @endif
            </ul>
        </div>
        <div class="col-md-12 mt-3">
            <h5 class="text-secondary">Materias</h5>
            <ul class="m-0 p-0">
                @foreach($user->materias as $materia)
                <li class="mt-3">
                    {{ $materia->nombre.' - '.$materia->carrera->nombre.' - '.$materia->carrera->sede->nombre }}
                    -
                    <form action="{{ route('delete_materias_carreras',['user_id'=> $user->id,'materia_id'=>$materia->id]) }}" method="POST" class="d-inline">
                        {{ method_field('DELETE') }}
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>

                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12 mt-3">
            <h5 class="text-secondary">Cargos</h5>
            <ul class="m-0 p-0">
                @foreach($user->cargos as $cargo)

                <li class="mt-3">
                    {{ $cargo->nombre.' - '.$cargo->carrera->nombre.' - '.$cargo->carrera->sede->nombre }}
                    -
                    <form action="{{ route('delete_cargo_carreras',['user_id'=> $user->id,'cargo_id'=>$cargo->id]) }}" method="POST" class="d-inline">
                        {{ method_field('DELETE') }}
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>

                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12 mt-3">
            @if($sedes)
            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$user->id}}">
                Asignar Sedes
            </button>
            @include('user.modals.admin_sedes')
            @if($materias)
            <button type="button" class="ml-2 btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#materiasModal{{$user->id}}">
                Asignar Materias (Tradicional)
            </button>
            @include('user.modals.admin_carreras_materias')
            @endif
            @if($cargos)
            <button type="button" class="ml-2 btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#cargosModal{{$user->id}}">
                Asignar Cargos (Modular)
            </button>
            @include('user.modals.admin_carreras_cargos')
            @endif
            @if(Session::has('admin'))
            <button type="button" class="ml-2 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#carrerasModal{{$user->id}}">
                Asignar Carreras
            </button>
            <button type="button" class="ml-2 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#rolesModal{{$user->id}}">
                Asignar Roles
            </button>
            @include('user.modals.admin_carreras')
            @include('user.modals.admin_roles')
            @endif
            @endif

        </div>
    </div>

</div>
@endsection
@section('scripts')
<script src="{{ asset('js/user/carreras.js') }}"></script>
<script src="{{ asset('js/user/cargos.js') }}"></script>
@endsection