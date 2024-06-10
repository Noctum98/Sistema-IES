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
            <h4 class="m-0">Admin Managers</h4>
            <div>
                <a href="{{ route('admin_managers.admin_manager.create') }}" class="btn btn-secondary"
                   title="Agregar Admin Manager">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($adminManagers) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron admin managers.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Habilitado</th>
                            <th>Icon</th>
                            <th>Link</th>
                            <th>Model</th>
                            <th>Nombre</th>

                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($adminManagers as $adminManager)
                            <tr>
                                <td class="align-middle">{{ ($adminManager->enabled) ? 'Si' : 'No' }}</td>
                                <td class="align-middle">{{ $adminManager->icon }}</td>
                                <td class="align-middle">{{ $adminManager->link }}</td>
                                <td class="align-middle">{{ $adminManager->model }}</td>
                                <td class="align-middle">{{ $adminManager->name }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('admin_managers.admin_manager.destroy', $adminManager->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin_managers.admin_manager.show', $adminManager->id ) }}"
                                               class="btn btn-info" title="Ver">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('admin_managers.admin_manager.edit', $adminManager->id ) }}"
                                               class="btn btn-primary" title="Editar Admin Manager">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                                Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Admin Manager"
                                                    onclick="return confirm('Aceptar para eliminar Admin Manager.')">
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

                {!! $adminManagers->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
