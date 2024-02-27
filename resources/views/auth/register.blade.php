@extends('layouts.app-prueba')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Registro de Usuarios') }}

                        <span class="aviso"></span>
                        <span class="spin d-none"><i class="fa fa-spinner fa-spin"></i> Buscando usuario ... </span>
                    </div>

                    <div class="card-body">
                        @if(@session('message_success'))
                            <div class="alert alert-success">
                                {{ @session('message_success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            @include('auth.register-form')

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
