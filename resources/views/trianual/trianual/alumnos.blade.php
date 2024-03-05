@extends('layouts.app-prueba')

@section('content')
    <style>
        .card {
            /*margin-top: 2em;*/
            padding: 0.5em;
            border-radius: 2em;
            /*text-align: center;*/
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .card li {
            list-style: none;
        }

        .card_img {
            /*width: 65%;*/
            /*border-radius: 50%;*/
            border-radius: 2em;
            margin: 0 auto 0 -50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background: #1a1e21;
            color: white;
            font-size: 6em;
            font-weight: bold;
        }

        .card .card-title {
            font-weight: 700;
            font-size: 1.5em;
        }

        /*.card .btn {*/
        /*    border-radius: 2em;*/
        /*    background-color: teal;*/
        /*    color: #ffffff;*/
        /*    padding: 0.5em 1.5em;*/
        /*}*/

        .card .btn:hover {
            background-color: rgba(0, 128, 128, 0.7);
            color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
    <div class="col-md-12 row mb-3">
        <div class="card">
            <div class="row">
                <div class="card-body col-sm-9 mx-auto text-center">
                    <div class="card-subtitle">
                        Se var a generar trianuales para los alumnos de {{$year}}° año
                    </div>
                    <div class="card-title">
                        Carrera {{$carrera->nombre}}</div>
                </div>
            </div>
        </div>


        <div class="card pl-5">
            <div class="row">

                <!-- Verificamos que la variable $alumnos no esté vacía -->
                @if (!empty($alumnos))
                    <table class="table">
                        <thead>
                        <tr>
                            @if(Session::has('admin'))
                                <th>id</th>
                            @endif
                            <th>Apellido, Nombre</th>
                            <th>Documento</th>

                            <th>Cohorte</th>
                            <!-- Aquí otros detalles del alumno que te gustaría visualizar -->
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Recorremos cada alumno y mostramos sus detalles -->
                        @foreach ($alumnos as $alumno)
                            <tr>
                                @if(Session::has('admin'))
                                    <td>{{ $alumno->id }}</td>
                                @endif
                                <td>{{ $alumno->getApellidosNombresAttribute() }}</td>
                                <td>{{ $alumno->getDocumento() }}</td>
                                <td>{{ $alumno->cohorte}}</td>
                                <!-- Aquí otros atributos del alumno -->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No se encontraron alumnos para esta carrera.</p>
                @endif
            </div>
        </div>
        <div class="row-cols-1">
            <div class="card w-75 mx-auto">
                <div class="card-header text-center text-primary">
                    <div class="card-title">
                        Los trianuales deberán ser editados por cada alumno individualmente
                    </div>
                    <div class="card-subtitle">
                        La mayoría de los datos son obtenidos de aquellos cargados en los alumnos, materias, carreras y
                        sedes
                    </div>
                </div>
                <div class="card-footer">
                    <div class="blockquote blockquote-footer mt-1 mb-0">
                        Operador: {{Auth::user()->apellido}}, {{Auth::user()->nombre}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
