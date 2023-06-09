@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h4 class="text-info">Carga horaria de {{ $user->nombre.' '.$user->apellido}}</h4>
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
            <div class="col-md-10 mx-auto">
                <h5 class="text-secondary">Carreras</h5>
                <div class="row ">
                    @if(count($user->carreras) > 0)
                        @foreach($user->carreras as $carrera)
                            <div class="col-4 border-bottom ">
                                <b>{{$carrera->nombre}}</b>
                            </div>
                            <div class="col-4 border-bottom ">
                                <small> <i>Res N°:{{$carrera->resolucion.'  Turno:'.$carrera->turno}}</i></small>
                            </div>
                            <div class="col-4 border-bottom ">
                                {{ $carrera->sede->nombre }}
                            </div>
                            <div class="col-md-2">
                                Materias
                            </div>
                            @foreach($user->materias as $materia)
                                @if($materia->carrera->id == $carrera->id)
                                    <div class="col-md-10 ms-5">
                                        {{ $materia->nombre }}
                                    </div>

                                @endif
                            @endforeach
                            <div class="col-md-10 ms-5">
                            </div>
                            <div class="col-md-2">
                                Cargos
                            </div>
                            @foreach($user->cargos as $cargo)
                                @if($cargo->carrera->id == $carrera->id )
                                    <div class="col-md-10 ms-5">
                                        {{ $cargo->nombre }}
                                    </div>
                                @endif
                            @endforeach
                            <hr class="p-0"/>
                        @endforeach
                    @else
                        <p>No hay carreras vinculadas al usuario.</p>
                    @endif

                </div>


            </div>

        </div>
        @endsection
        @section('scripts')
            <script src="{{ asset('js/user/carreras.js') }}"></script>
            <script src="{{ asset('js/user/cargos.js') }}"></script>
@endsection
