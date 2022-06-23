@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Calificaciones: {{ $materia->nombre }}
    </h2>
    <hr>
    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#crearCalificacion">Crear Calificación</button>
    <!---
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0 mt-1" method="GET" action="#" id="buscador">
        <div class="input-group mt-3">
            <input class="form-control ml-3" type="text" id="busqueda" placeholder="Buscar calificación" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </form>
    --->
    @if(@session('calificacion_creada'))
    <div class="alert alert-success mt-2">{{@session('calificacion_creada')}}</div>
    @endif

    @if(@session('calificacion_fallo'))
    <div class="alert alert-warning mt-2">{{@session('calificacion_fallo')}}</div>
    @endif

    @if(@session('calificacion_eliminada'))
    <div class="alert alert-danger mt-2">{{@session('calificacion_eliminada')}}</div>
    @endif

    @if(@session('error_comision'))
    <div class="alert alert-danger mt-2">{{@session('error_comision')}}</div>
    @endif

    @if(count($calificaciones) > 0)
    <table class="table  mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Fecha</th>
                <th scope="col">Comisión</th>
                <th scope="col" class="text-center"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calificaciones as $calificacion)
            <tr style="cursor:pointer;">
                <td>{{ $calificacion->tipo->nombre }}</td>
                <td>{{ $calificacion->nombre }}</td>
                <td>{{ $calificacion->fecha }}</td>
                @if( $calificacion->comision_id)
                <td>{{ $calificacion->comision->nombre }}</td>
                @else
                <td>General</td>
                @endif
                <td >
                    <a href="{{ route('calificacion.create',$calificacion->id) }}" class="btn btn-sm btn-secondary 
                    @if (Session::has('profesor') && !Session::has('coordinador') && $calificacion->comision_id && !Auth::user()->hasComision($calificacion->comision_id)) disabled @endif" 
                    >
                        Notas
                    </a>
                    <form action="{{ route('calificacion.delete',$calificacion->id) }}" method="POST" class="d-inline">
                        {{ method_field('DELETE') }}
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger" @if (Session::has('profesor') && !Session::has('coordinador') && $calificacion->comision_id && !Auth::user()->hasComision($calificacion->comision_id)) disabled @endif>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
     <p class="mt-3">No has creado ninguna calificación.</p>
    @endif
</div>
@include('calificacion.modals.crear_calificacion')
@endsection