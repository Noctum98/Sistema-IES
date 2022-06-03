@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Calificaciónes: {{ $materia->nombre }}
    </h2>
    <hr>
    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#crearCalificacion">Crear Calificación</button>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0 mt-1" method="GET" action="#" id="buscador">
        <div class="input-group mt-3">
            <input class="form-control ml-3" type="text" id="busqueda" placeholder="Buscar calificación" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </form>
    @if(@session('calificacion_creada'))
    <div class="alert alert-success">{{@session('calificacion_creada')}}</div>
    @endif

    <table class="table  mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Fecha</th>
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calificaciones as $calificacion)
            <tr style="cursor:pointer;">
                <td>{{ $calificacion->tipo->nombre }}</td>
                <td>{{ $calificacion->nombre }}</td>
                <td>{{ $calificacion->fecha }}</td>

                <td>
                    <a href="" class="btn btn-sm btn-secondary">
                        Notas
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('calificacion.modals.crear_calificacion')
@endsection