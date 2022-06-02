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
        <div class="row">
            <div class="col-sm-3">
                <h5 class="text-secondary">Datos Personales </h5>
            </div>
            <div class="col-md-9">
                <ul class="m-0 p-0">
                    <li><strong>Nombre:</strong> {{ $user->nombre }} </li>
                    <li><strong>Apellido:</strong> {{ $user->apellido }}</li>
                    <li><strong>Email:</strong> {{ $user->email }}</li>
                    <li><strong>Teléfono:</strong> {{ $user->telefono }}</li>
                    <li><strong>Username:</strong> {{ $user->username }}</li>
                </ul>
            </div>
            <hr class="mt-2"/>
            <div class="col-sm-3">
                <h5 class="text-secondary">Mis Carreras </h5>
            </div>
            <div class="col-md-9 ">
                <ul class="m-0 p-0">
                    @if(count($user->carreras) > 0)
                        @foreach($user->carreras as $carrera)
                            <li>
                                <strong>{{ $carrera->nombre}}</strong>
                                <small>
                                    (R.N°: {{$carrera->resolucion}} T: {{ucfirst($carrera->turno)}})
                                    <i>{{$carrera->sede->nombre}}</i>
                                </small>
                            </li>
                        @endforeach
                    @else
                        <p>Sin carreras asignadas.</p>
                    @endif
                </ul>
            </div>
            <hr class="mt-2"/>
            <div class="col-sm-3">
                <h5 class="text-secondary">Mis Materias</h5>
            </div>
            <div class="col-sm-9">
                <ul class="m-0 p-0">
                    @if(count($user->materias) > 0)
                        @foreach($user->materias as $materia)
                            <li>
                                <strong>{{ $materia->nombre}}</strong>
                                <small>
                                    {{$materia->carrera->nombre}}
                                    <i>{{$materia->carrera->sede->nombre }}</i>
                                </small>
                            </li>
                        @endforeach
                    @else
                        <li>Sin materias asignadas</li>
                    @endif
                </ul>
            </div>
            <hr class="mt-2"/>
            <div class="col-sm-3">
                <h5 class="text-secondary">Mis Cargos</h5>
            </div>
            <div class="col-sm-9">
                <ul class="m-0 p-0">
                    @if(count($user->cargos) > 0)
                        @foreach($user->cargos as $cargo)

                            <li>
                                <strong> {{ $cargo->nombre}} </strong>
                                <small>
                                    {{$cargo->carrera->nombre}} <i>{{$cargo->carrera->sede->nombre }}</i>
                                </small>
                            </li>
                        @endforeach
                    @else
                        <li>Sin cargos asignados</li>
                    @endif
                </ul>
            </div>
            <hr class="mt-2"/>
            <div class="col-sm-3">
                <h5 class="text-secondary">Nivel Usuario</h5>
            </div>
            <div class="col-sm-9">
                <ul class="m-0 p-0">
                    @if(count($nivel_usuario) > 0)
                        @foreach($nivel_usuario as $nivel)

                            <li>
                                <strong> {{ $nivel->nombre}} </strong>
                                <small>
                                    {{$nivel->descripcion}}
                                </small>
                            </li>
                        @endforeach
                    @else
                        <li>Sin asignar</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
