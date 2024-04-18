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
                    <div class="card bg-warning bg-opacity-25 pl-3">
                      
                    </div>
                    <div class="card bg-primary bg-opacity-25">
                        <div class="card-header">
                            <div class="card-title">
                                <i><b>Información importante</b></i>
                            </div>
                            <div class="card-subtitle ml-5">Navegadores soportados</div>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>Chrome versión mayor o igual a 60</li>
                                <li>Firefox versión mayor o igual a 60</li>
                                <li>Firefox versión ESR</li>
                                <li>iOS versión mayor o igual a 12</li>
                                <li>Safari versión mayor o igual a 12</li>
                                <li>No es soportado Internet Explorer versiones menores o iguales a la v11</li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            Para optimizar los últimos resultados se aconseja refrescar el navegador con la combinación
                            de teclas “Ctrl + F5” o “Ctrl + R”
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
