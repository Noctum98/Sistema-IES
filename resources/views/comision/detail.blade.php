@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
    <a href="{{url()->previous()}}" ><button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button> </a>

    <h2 class="h1 text-info">
        Comisión de {{ $comision->nombre.' - '.$comision->carrera->nombre }}
    </h2>
    <hr>
    @if(Session::has('coordinador') || Session::has('regente') || Session::has('admin'))
    <p><button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarProfesor">Agregar Profesor</button></p>
    @endif
    @if(count($comision->profesores) == 0)
    <p>No hay profesores vinculados a la comisión.</p>
    @else

    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">
                    <i class="fa fa-cog" style="font-size:20px;"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comision->profesores as $profesor)
            <tr>
                <th scope="row">{{ $profesor->id }}</th>
                <td>{{ $profesor->nombre.' '.$profesor->apellido }}</td>
                <td>
                    <form action="{{ route('cargo.delUser',$profesor->id) }}" method="POST">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="user_id" value="{{$profesor->id}}">
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <hr>
    <p><button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarProfesor">Agregar Alumno</button></p>
    @if(count($comision->procesos) == 0)
    <p>No hay alumnos vinculados a la comisión.</p>
    @else

    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">
                    <i class="fa fa-cog" style="font-size:20px;"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comision->procesos as $proceso)
            <tr>
                <th scope="row">{{ $alumno->id }}</th>
                <td>{{ $proceso->alumno->nombre.' '.$proceso->alumno->apellido }}</td>
                <td>
                    <form action="{{ route('cargo.delUser',$proceso->id) }}" method="POST">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="user_id" value="{{$proceso->id}}">
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <hr>
</div>
@include('comision.modals.agregar_profesor')
@endsection