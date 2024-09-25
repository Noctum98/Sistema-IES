@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($estadoResoluciones->name) ? $estadoResoluciones->name : 'Estado Resoluciones' }}</h4>
            <div>
                <form method="POST"
                      action="{!! route('estado_resoluciones.estado_resoluciones.destroy', $estadoResoluciones->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('estado_resoluciones.estado_resoluciones.edit', $estadoResoluciones->id ) }}"
                       class="btn btn-primary" title="Editar Estado Resoluciones">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar Estado Resoluciones"
                            onclick="return confirm(&quot;Click Ok para borrar Estado Resoluciones.?&quot;)">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                    </button>

                    <a href="{{ route('estado_resoluciones.estado_resoluciones.index') }}" class="btn btn-primary"
                       title="Listado Estados Resoluciones">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                    </a>

                    <a href="{{ route('estado_resoluciones.estado_resoluciones.create') }}" class="btn btn-secondary"
                       title="Agregar Estado Resoluciones">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $estadoResoluciones->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
                <dd class="col-lg-10 col-xl-9">{{ $estadoResoluciones->identifier }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Deshabilitado</dt>
                <dd class="col-lg-10 col-xl-9">{{ ($estadoResoluciones->disabled) ? 'Si' : 'No' }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Borrado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $estadoResoluciones->deleted_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $estadoResoluciones->created_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $estadoResoluciones->updated_at }}</dd>

            </dl>

        </div>
    </div>

@endsection
