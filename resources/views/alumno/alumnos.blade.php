@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1 text-info">
            Alumnos de {{ $carrera->nombre }}
        </h2>
        <p>
            Selecciona el año para mostrar los alumnos de cada uno
        </p>
        <hr>
        <div class="col-md-11">
            @if(@session('alumno_deleted'))
                <div class="alert alert-warning">
                    {{ @session('alumno_deleted') }}
                </div>
            @endif
            <div class="col-md-6 row mb-3">
                <div class="col-md-6 mr-2">
                    <form method="GET" action="#" id="buscador-alumnos" class="form-inline">
                        <div class="row pr-2">
                            <div class="input-group">
{{--                                <div class="input-group-append">--}}

{{--                                </div>--}}
                                <input type="text" id="busqueda" class="form-control" placeholder="Buscar alumno"
                                       aria-describedby="inputGroupPrepend2"
                                >
                                <button class="input-group-text" id="inputGroupPrepend2" type="submit">
                                    <i class="fa fa-search text-info"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="text-secondary" style="cursor: pointer;" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-bs-expanded="true" aria-bs-controls="collapseOne">
                            Primer Año
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-bs-labelledby="headingOne"
                         data-bs-parent="#accordion">
                        <div class="card-body">
                            <a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>1]) }}"
                               class="btn btn-sm btn-success mb-2">Descargar Alumnos</a>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Nombre y Apellido</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($carrera->alumnos as $alumno)
                                        @if($alumno->procesoCarrera($carrera->id,$alumno->id)->año == 1)
                                            <tr>
                                                <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
                                                <td>{{ $alumno->dni }}</td>
                                                <td>
                                                    <a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}"
                                                       class="btn btn-sm btn-secondary mr-1">
                                                        Ver datos
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 style="cursor:pointer;" class="collapsed text-secondary" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-bs-expanded="false" aria-bs-controls="collapseTwo">
                            Segundo Año
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-bs-labelledby="headingTwo" data-bs-parent="#accordion">
                        <div class="card-body">
                            <a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>2]) }}"
                               class="btn btn-sm btn-success mb-2">Descargar Alumnos</a>
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nombre y Apellido</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($carrera->alumnos as $alumno)
                                    @if($alumno->procesoCarrera($carrera->id,$alumno->id)->año == 2)
                                        <tr>
                                            <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
                                            <td>{{ $alumno->dni }}</td>
                                            <td>
                                                <a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}"
                                                   class="btn btn-sm btn-secondary">
                                                    Ver datos
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 style="cursor:pointer" class="collapsed text-secondary" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-bs-expanded="false" aria-bs-controls="collapseThree">
                            Tercer Años
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-bs-labelledby="headingThree"
                         data-bs-parent="#accordion">
                        <div class="card-body">
                            <a href="{{ route('excel.alumnosAño',['carrera_id'=>$carrera->id,'year'=>3]) }}"
                               class="btn btn-sm btn-success mb-2">Descargar Alumnos</a>
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nombre y Apellido</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($carrera->alumnos as $alumno)
                                    @if($alumno->procesoCarrera($carrera->id,$alumno->id)->año == 3)
                                        <tr>
                                            <td>{{$alumno->nombres.' '.$alumno->apellidos}}</td>
                                            <td>{{ $alumno->dni }}</td>
                                            <td>
                                                <a href="{{ route('alumno.detalle',['id'=>$alumno->id]) }}"
                                                   class="btn btn-sm btn-secondary">
                                                    Ver datos
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection('content')
