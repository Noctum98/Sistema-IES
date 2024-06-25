@extends('layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Libro Papel (físico)</h4>
            <div>
                <a href="{{ route('libro_papel.libro_papel.create') }}" class="btn btn-secondary"
                   title="Agregar Libro Papel">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($librosPapel) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron libros físcos registrados.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Numero</th>
                            <th>N° Romanos</th>
                            <th>Acta Inicio</th>
                            <th>Operador Inicio</th>
                            <th>Fecha Inicio</th>
                            <th>Sede</th>
                            <th>User</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($librosPapel as $libroPapel)
                            <tr>
                                <td class="align-middle">{{ $libroPapel->name }}</td>
                                <td class="align-middle">{{ $libroPapel->number }}</td>
                                <td class="align-middle">{{ $libroPapel->roman }}</td>
                                <td class="align-middle">{!! Str::words("$libroPapel->acta_inicio", 5,' ...') !!}</td>
                                <td class="align-middle">{{ $libroPapel->operador_inicio }}</td>
                                <td class="align-middle">{{ $libroPapel->fecha_inicio }}</td>
                                <td class="align-middle">{{ optional($libroPapel->sede)->nombre }}</td>
                                <td class="align-middle">{{ optional($libroPapel->user)->getApellidoNombre() }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('libro_papel.libro_papel.destroy', $libroPapel->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('libro_papel.libro_papel.show', $libroPapel->id ) }}"
                                               class="btn btn-info" title="Ver Libro Papel">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('libro_papel.libro_papel.edit', $libroPapel->id ) }}"
                                               class="btn btn-primary" title="Editar Libro Papel">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                                Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Eliminar Libro Papel"
                                                    onclick="return confirm('Aceptar para confirmar la eliminación del Libro Papel')">
                                                <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                                                Eliminar
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $librosPapel->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
