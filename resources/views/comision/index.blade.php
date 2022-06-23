@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
    <a href="{{route('materia.admin',$carrera->id)}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
    <h2 class="h1 text-info">
        Comisiones de {{ $carrera->nombre }}
    </h2>
    <hr>
    @if(@session('comision_eliminada'))
    <div class="alert alert-warning">
        {{ @session('comision_eliminada') }}
    </div>
    @endif
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Año</th>
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($comisiones as $comision)
            <tr style="cursor:pointer;">
                <td>{{ $comision->nombre }}</td>
                <td>
                    {{ $comision->año }}
                </td>
                <td>
                    <a href="{{ route('comisiones.show',$comision->id) }}" class="btn btn-sm btn-secondary">Ver</a>
                    <form action="{{route('comisiones.destroy',$comision->id)}}" method="POST" class="d-inline">
                        {{ method_field('DELETE') }}
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{url()->previous()}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
</div>
@endsection