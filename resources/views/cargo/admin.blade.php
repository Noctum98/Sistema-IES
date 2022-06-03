@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        @if(@session('cargo_deleted'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
            </svg>
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    {{ @session('cargo_deleted') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
                                <form method="POST" class="d-inline"
                                      action="{{route('cargo.delete', ['cargo' => $cargo->id])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Se borrará el registro. ¿Confirma?.')"
                                            type="submit"> Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h4 class="text-secondary">No existen cargos creados</h4>
        @endif
            <div class="d-flex justify-content-center" style="font-size: 0.8em">
                {{ $cargos->links() }}
            </div>
    </div>
@endsection
