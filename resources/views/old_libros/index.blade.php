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
            <h4 class="m-0">Libros (Maestros)</h4>
            <div>
                <a href="{{ route('old_libros.old_libros.create') }}" class="btn btn-secondary"
                   title="Agregar Libro (Maestro)">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($oldLibrosObjects) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Libros (Maestros).</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($oldLibrosObjects as $oldLibros)
                            <tr>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('old_libros.old_libros.destroy', $oldLibros->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('old_libros.old_libros.show', $oldLibros->id ) }}"
                                               class="btn btn-info" title="Ver Libro (Maestro)">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span>
                                            </a>
                                            <a href="{{ route('old_libros.old_libros.edit', $oldLibros->id ) }}"
                                               class="btn btn-primary" title="Editar Libro (Maestro)">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Old Libros"
                                                    onclick="return confirm('Aceptar para eliminar Libro (Maestro)')">
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

                {!! $oldLibrosObjects->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
