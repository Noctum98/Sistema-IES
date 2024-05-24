@extends('layouts.app-prueba')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Estados Carrera</h4>
            <div>
                <a href="{{ route('estado_carreras.estado_carrera.create') }}" class="btn btn-secondary"
                   title="Nuevo Estado Carrera">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($estadoCarreras) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Estados Carrera Disponibles.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Identificador</th>
                            <th>Deshabilitado</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($estadoCarreras as $estadoCarrera)
                            <tr>
                                <td class="align-middle">{{ $estadoCarrera->name }}</td>
                                <td class="align-middle">{{ $estadoCarrera->identifier }}</td>
                                <td class="align-middle">{{ ($estadoCarrera->disabled) ? 'Si' : 'No' }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('estado_carreras.estado_carrera.destroy', $estadoCarrera->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('estado_carreras.estado_carrera.show', $estadoCarrera->id ) }}"
                                               class="btn btn-info" title="Ver Estado Carrera">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('estado_carreras.estado_carrera.edit', $estadoCarrera->id ) }}"
                                               class="btn btn-primary" title="Editar Estado Carrera">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Estado Carrera"
                                                    onclick="return confirm(&quot;Click Ok para borrar Estado Carrera.&quot;)">
                                                <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $estadoCarreras->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
