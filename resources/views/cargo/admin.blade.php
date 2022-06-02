@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1 text-info">Cargos
            <form class="me-2 d-inline-flex" action="{{ route('cargo.admin') }}">
                <div class="input-group mt-3">
                    <input class="form-control mx-auto" type="text" id="search" name="search"
                           placeholder="Buscar cargo" aria-label="Search">
                    <button class="btn btn-outline-primary me-2" type="submit"><i
                                class="fa fa-search"></i></button>
                </div>
            </form>
        </h2>
        <h6>
            <i>Administrar Cargos</i></h6>
        <hr>
        <p>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearCargo">Crear Cargo</button>
        </p>
        @include('cargo.modals.crear_cargo')

        @if(count($cargos) > 0)
            <div class="table-responsive">

                <table class="table mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="text-center">
                            <i class="fa fa-cog" style="font-size:20px;"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cargos as $cargo)
                        <tr>
                            <th scope="row">{{ $cargo->id }}</th>
                            <td>{{ $cargo->nombre }}</td>
                            <td class="text-center">
                                <a href="{{ route('cargo.show',$cargo->id) }}"
                                   class="btn btn-sm btn-primary block-inline ">Configurar</a>

                                <a href="{{ route('cargo.edit',$cargo->id) }}"
                                   class="btn btn-sm btn-warning ">Editar</a>
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
