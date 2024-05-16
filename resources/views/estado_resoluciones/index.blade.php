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
            <h4 class="m-0">Estados Resoluciones</h4>
            <div>
                <a href="{{ route('estado_resoluciones.estado_resoluciones.create') }}" class="btn btn-secondary"
                   title="Agregar nuevo Estado Resoluciones">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($estadoResolucionesObjects) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Estados Resoluciones disponibles.</h4>
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
                        @foreach($estadoResolucionesObjects as $estadoResoluciones)
                            <tr>
                                <td class="align-middle">{{ $estadoResoluciones->name }}</td>
                                <td class="align-middle">{{ $estadoResoluciones->identifier }}</td>
                                <td class="align-middle">{{ ($estadoResoluciones->disabled) ? 'Si' : 'No' }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('estado_resoluciones.estado_resoluciones.destroy', $estadoResoluciones->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('estado_resoluciones.estado_resoluciones.show', $estadoResoluciones->id ) }}"
                                               class="btn btn-info" title="Ver Estado Resoluciones">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('estado_resoluciones.estado_resoluciones.edit', $estadoResoluciones->id ) }}"
                                               class="btn btn-primary" title="Editar Estado Resoluciones">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger"
                                                    title="Borrar Estado Resoluciones"
                                                    onclick="return confirm(&quot;Click Ok para borrar Estado Resoluciones.&quot;)">
                                                <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Borrar
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $estadoResolucionesObjects->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
