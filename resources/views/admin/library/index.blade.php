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
            <h4 class="m-0">Bibliotecas</h4>
            <div>
                <a href="{{ route('admin-libraries.library.create') }}" class="btn btn-secondary" title="Agregar">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($libraries) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron bibliotecas.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Nombre biblioteca</th>
                            <th>Link</th>
                            <th>Orden</th>
                            <th class="text-center"><i class="fa fa-cogs" aria-hidden="true"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($libraries as $library)
                            <tr>
                                <td class="align-middle">{{ $library->name }}</td>
                                <td class="align-middle">{{ $library->link }}</td>
                                <td class="align-middle">{{ $library->orden }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('admin-libraries.library.destroy', $library->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin-libraries.library.show', $library->id ) }}"
                                               class="btn btn-info" title="Ver">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('admin-libraries.library.edit', $library->id ) }}"
                                               class="btn btn-primary" title="Editar">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                                Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Borrar"
                                                    onclick="return confirm('Está seguro de borrar la biblioteca.')">
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

                {!! $libraries->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
