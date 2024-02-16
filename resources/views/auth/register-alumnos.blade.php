@extends('layouts.app-prueba')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro de Alumnos') }}

                    <span class="aviso"></span>
                    <span class="spin d-none"><i class="fa fa-spinner fa-spin"></i> Buscando usuario ... </span>
                </div>

                <div class="card-body">
                    @if(@session('message_success'))
                    <div class="alert alert-success">
                        {{ @session('message_success') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('register.alumno.store') }}">
                        @csrf

                        @include('auth.register-form',['rolesHidden'=>true])

                        <div class="form-group">
                        </div>

                        <div class="form-group row">
                            <label for="carrera_id" class="col-md-4 col-form-label text-md-right">Carrera</label>

                            <div class="col-md-6">
                                <select class="form-select" name="carrera_id" id="carrera_id" required>
                                    @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ $carrera->id == $carreraSelected->id ? 'selected' : '' }}>
                                        {{ $carrera->sede->nombre.' - '.$carrera->nombre.':'.ucwords($carrera->turno).' - '.$carrera->resolucion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="año" class="col-md-4 col-form-label text-md-right">Año</label>

                            <div class="col-md-6">
                                <input id="año" type="number" class="form-control" name="año" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ciclo_lectivo" class="col-md-4 col-form-label text-md-right">Ciclo Lectivo</label>

                            <div class="col-md-6">
                                <input id="ciclo_lectivo" type="number" class="form-control" name="ciclo_lectivo" value="{{ date('Y') }}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="submit">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/user/busquedaInput.js') }}"></script>
@endsection