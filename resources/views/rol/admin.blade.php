@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Administrar Roles
    </h2>
    <hr>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearRol">
        Crear Rol
    </button>
    @if(@session('rol_creado'))
    <div class="alert alert-success">
        {{ @session('rol_creado') }}
    </div>
    @endif
    @if(@session('rol_eliminado'))
    <div class="alert alert-success">
        {{ @session('rol_eliminado') }}
    </div>
    @endif
    <h4 class="text-secondary">Roles Principales</h4>

    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Activo</th>
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles_primarios as $rol)
            <tr>
                <th scope="row">{{ $rol->id }}</th>
                <td>{{ $rol->nombre }}</td>
                <td>{{ $rol->descripcion }}</td>
                <td>
                    @if($rol->activo)
                    <i class='fas fa-check' style='font-size:14px;color:green'></i>
                    @else
                    <i class='fas fa-times' style='font-size:14px;color:red'></i>
                    @endif
                </td>
                <td>
                    @if($rol->activo)
                    <a class="col-md-3 btn btn-sm btn-secondary" href="{{ route('rol.cambiarEstado',$rol->id) }}">Desactivar</a>
                    @else
                    <a class="col-md-3 btn btn-sm btn-success" href="{{ route('rol.cambiarEstado',$rol->id) }}">Activar</a>
                    @endif <a href="{{ route('roles.destroy',$rol->id) }}" type="button" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <h4 class="text-secondary">Roles Secundarios</h4>
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Activo</th>
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles_secundarios as $rol)
            <tr>
                <th scope="row">{{ $rol->id }}</th>
                <td>{{ $rol->nombre }}</td>
                <td>{{ $rol->descripcion }}</td>
                <td>
                    @if($rol->activo)
                    <i class='fas fa-check' style='font-size:14px;color:green'></i>
                    @else
                    <i class='fas fa-times' style='font-size:14px;color:red'></i>
                    @endif
                </td>
                <td class="row">
                    @if($rol->activo)
                    <a class="col-md-3 btn btn-sm btn-secondary" href="{{ route('rol.cambiarEstado',$rol->id) }}">Desactivar</a>
                    @else
                    <a class="col-md-3 btn btn-sm btn-success" href="{{ route('rol.cambiarEstado',$rol->id) }}">Activar</a>
                    @endif
                    <form action="{{ route('roles.destroy',$rol->id) }}" method="POST" class="col-md-2">
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @include('rol.modals.crear_rol')
</div>
@endsection