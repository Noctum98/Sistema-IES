@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($library->name) ? $library->name : 'Biblioteca' }}</h4>
            <div>
                <form method="POST" action="{!! route('admin-libraries.library.destroy', $library->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('admin-libraries.library.edit', $library->id ) }}" class="btn btn-primary"
                       title="Editar">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar"
                            onclick="return confirm('¿Está seguro de borrar la biblioteca?')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Borrar
                    </button>

                    <a href="{{ route('admin-libraries.library.index') }}" class="btn btn-primary" title="Listar">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listar
                    </a>

                    <a href="{{ route('admin-libraries.library.create') }}" class="btn btn-secondary"
                       title="Agregar">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $library->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Link</dt>
                <dd class="col-lg-10 col-xl-9">{{ $library->link }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Orden</dt>
                <dd class="col-lg-10 col-xl-9">{{ $library->orden }}</dd>
                @if($library->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Eliminada</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $library->deleted_at }}</dd>
                @endif
                <dt class="text-lg-end col-lg-2 col-xl-3">Agregada el</dt>
                <dd class="col-lg-10 col-xl-9">{{ $library->created_at }}</dd>
                @if($library->created_at !== $library->updated_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizada el</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $library->updated_at }}</dd>
                @endif
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ $library->user_id }}</dd>
            </dl>
    </div>
</div>

@endsection
