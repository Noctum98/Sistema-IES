@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">Cargos</h2>
    <i>Administrar Cargos</i>
    <hr>
    <p><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearCargo">Crear Cargo</button></p>
    @include('cargo.modals.crear_cargo')

    @if(count($cargos) > 0)
    <div class="table-responsive">

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
                @foreach ($cargos as $cargo)
                <tr>
                    <th scope="row">{{ $cargo->id }}</th>
                    <td>{{ $cargo->nombre }}</td>
                    <td>
                        <a href="{{ route('cargo.show',$cargo->id) }}" class="btn btn-sm btn-primary">Configurar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <h4 class="text-secondary">No existen cargos creados</h4>
    @endif
</div>
@endsection