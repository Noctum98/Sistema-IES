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
                        tu contraseña en la sección “Mi Perfil” del menú desplegable.
                    </div>
                    <div class="card-footer">
                        <div class="card-title">
                            Navegadores soportados
                        </div>
                        <p>
                            Chrome versión >= 60<br/>
                            Firefox versión >= 60 <br/>
                            Firefox versión ESR <br/>
                            iOS versión >= 12 <br/>
                            Safari versión >= 12 <br/>
                            No es soportado Internet Explorer versiones menores o iguales a la v11
                        </p>
                        <p>
                            Para optimizar los últimos resultados se aconseja refrescar el navegador con la combinación
                            de teclas “Ctrl + F5” o “Ctrl + R”
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
