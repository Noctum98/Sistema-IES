@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($adminManager->name) ? $adminManager->name : 'Admin Manager' }}</h4>
            <div>
                <form method="POST" action="{!! route('admin_managers.admin_manager.destroy', $adminManager->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('admin_managers.admin_manager.edit', $adminManager->id ) }}"
                       class="btn btn-primary" title="Editar Admin Manager">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Admin Manager"
                            onclick="return confirm('Aceptar para confirmar la eliminación del Admin Manager.')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                    </button>

                    <a href="{{ route('admin_managers.admin_manager.index') }}" class="btn btn-primary"
                       title="Ver Admin Manager">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Ver
                    </a>

                    <a href="{{ route('admin_managers.admin_manager.create') }}" class="btn btn-secondary"
                       title="Agregar Admin Manager">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $adminManager->created_at }}</dd>
                @if($adminManager->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Deleted At</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $adminManager->deleted_at }}</dd>
                @endif

                <dt class="text-lg-end col-lg-2 col-xl-3">Habilitado</dt>
                <dd class="col-lg-10 col-xl-9">{{ ($adminManager->enabled) ? 'Si' : 'No' }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Icon</dt>
                <dd class="col-lg-10 col-xl-9">{{ $adminManager->icon }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Link</dt>
                <dd class="col-lg-10 col-xl-9">{{ $adminManager->link }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Model</dt>
                <dd class="col-lg-10 col-xl-9">{{ $adminManager->model }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $adminManager->name }}</dd>
                @if($adminManager->updated_at !== $adminManager->created_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $adminManager->updated_at }}</dd>
                @endif
            </dl>

        </div>
    </div>

@endsection
