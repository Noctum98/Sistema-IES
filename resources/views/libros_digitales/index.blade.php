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
                <a href="{{ route('libros_digitales.libros_digitales.create') }}" class="btn btn-secondary"
                   title="Agregar Libro (Maestro)">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($librosDigitalesObjects) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Libros Digitales.</h4>
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
                        @foreach($librosDigitalesObjects as $librosDigitales)
                            <tr>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('libros_digitales.libros_digitales.destroy', $librosDigitales->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('libros_digitales.libros_digitales.show', $librosDigitales->id ) }}"
                                               class="btn btn-info" title="Ver Libro Digital">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span>
                                            </a>
                                            <a href="{{ route('libros_digitales.libros_digitales.edit', $librosDigitales->id ) }}"
                                               class="btn btn-primary" title="Editar Libro Digital">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Eliminar Libro Digital"
                                                    onclick="return confirm('Aceptar para eliminar Libro Digital')">
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

                {!! $librosDigitalesObjects->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
