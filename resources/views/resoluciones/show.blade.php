@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($resoluciones->name) ? $resoluciones->name : 'Resolución' }}</h4>
            <div>
                <form method="POST" action="{!! route('resoluciones.resoluciones.destroy', $resoluciones->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('resoluciones.resoluciones.edit', $resoluciones->id ) }}" class="btn btn-primary"
                       title="Editar Resolución">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar Resoluciones"
                            onclick="return confirm(&quot;Click Ok para borrar Resolución.?&quot;)">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                    </button>

                    <a href="{{ route('resoluciones.resoluciones.index') }}" class="btn btn-primary"
                       title="Listar Resoluciones">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('resoluciones.resoluciones.create') }}" class="btn btn-secondary"
                       title="Crear Resolución">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span>
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Título</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->title }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Duración</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->duration }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Resolución</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->resolution }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Tipo</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->type }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Vacunas</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->vaccines }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Tipo Carrera</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($resoluciones->TipoCarrera)->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Estados</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($resoluciones->estado)->id }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Borrado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->deleted_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->created_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $resoluciones->updated_at }}</dd>

            </dl>

        </div>
    </div>

@endsection
