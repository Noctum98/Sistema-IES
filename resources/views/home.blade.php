@extends('layouts.app-prueba')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('images/logo.png') }}" alt="" height="150px">
                    </div>
                </div>
                <div class="card-header">Bienvenido a Sistema IES 9015 Valle de Uco</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">

                        </div>
                    @endif

                    Si has iniciado sesión con los datos por defecto, recomendamos cambiar
                    tu contraseña en la sección "Mi Perfil" del menú desplegable.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
