@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($regimen->name) ? $regimen->name : 'Régimen' }}</h4>
            <div>
                <form method="POST" action="{!! route('regimens.regimen.destroy', $regimen->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('regimens.regimen.edit', $regimen->id ) }}" class="btn btn-primary"
                       title="Editar Régimen">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar Regimen"
                            onclick="return confirm(&quot;Click Ok para borrar Régimen.?&quot;)">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                    </button>

                    <a href="{{ route('regimens.regimen.index') }}" class="btn btn-primary" title="Listar Regímenes">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('regimens.regimen.create') }}" class="btn btn-secondary" title="Crear Régimen">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span>
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $regimen->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
                <dd class="col-lg-10 col-xl-9">{{ $regimen->identifier }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Borrado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $regimen->deleted_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $regimen->created_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $regimen->updated_at }}</dd>

            </dl>

        </div>
    </div>

@endsection
