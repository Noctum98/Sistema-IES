@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">Configurar Cargo</h2>
    <hr>
    <p><i>{{ $cargo->nombre.' - '.$cargo->carrera->nombre.' ( '.$cargo->carrera->sede->nombre.' )' }}</i></p>
    <h3 class="text-secondary mb-3">Modulos</h3>
    <p><button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarModulo">Agregar módulo</button></p>
    @include('cargo.modals.agregar_modulo')
    @if(count($cargo->materias) == 0)
    <p>No hay materias vinculadas al cargo.</p>
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
            @foreach ($cargo->materias as $materia)
            <tr>
                <th scope="row">{{ $materia->id }}</th>
                <td>{{ $materia->nombre }}</td>
                <td>
                    <form action="{{ route('cargo.delMateria',$cargo->id) }}" method="POST">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="materia_id" value="{{$materia->id}}">
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif


    <h3 class="text-secondary mb-3">Usuarios</h3>
    <p><button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarUser">Agregar usuario</button></p>
    @include('cargo.modals.agregar_user')

    @if(count($cargo->users) == 0)
    <p>No hay usuarios vinculados al cargo.</p>
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
            @foreach ($cargo->users as $usuario)
            <tr>
                <th scope="row">{{ $usuario->id }}</th>
                <td>{{ $usuario->nombre.' '.$usuario->apellido }}</td>
                <td>
                    <form action="{{ route('cargo.delUser',$cargo->id) }}" method="POST">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="user_id" value="{{$usuario->id}}">
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/user/carreras.js') }}"></script>
@endsection