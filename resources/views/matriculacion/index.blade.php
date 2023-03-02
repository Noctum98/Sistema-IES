@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Inscripciónes de cursado
    </h2>
    <b><i>Selecciona el año que deseas cursar y completa el formulario.</i></b></br>
    <hr>
    <h4>Tus carreras</h4>
    <div class="table-responsive">
        <table class="table mt-2">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Carrera</th>
                    <th scope="col">UA</th>
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach (Auth::user()->carreras as $carrera)
                <tr style="cursor:pointer;">
                    <td>{{ $carrera->id }}</td>

                    <td>{{ $carrera->nombre.' - '.strtoupper($carrera->turno) }}</td>
                    <td>{{ $carrera->sede->nombre}}</td>

                    <td>
                        <a href="" class="btn btn-sm btn-secondary"  data-bs-toggle="modal" data-bs-target="#carreraAño{{$carrera->id}}">
                            <i class="fa fa-eye"></i>
                            Ver inscriptos
                        </a>
                        @include('matriculacion.modals.años')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection