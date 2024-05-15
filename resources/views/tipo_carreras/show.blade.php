@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($tipoCarrera->name) ? $tipoCarrera->name : 'Tipo Carrera' }}</h4>
            <div>
                <form method="POST" action="{!! route('tipo_carreras.tipo_carrera.destroy', $tipoCarrera->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('tipo_carreras.tipo_carrera.edit', $tipoCarrera->id ) }}" class="btn btn-primary"
                       title="Editar Tipo Carrera">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar Tipo Carrera"
                            onclick="return confirm(&quot;Click Ok para borrar Tipo Carrera.?&quot;)">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                    </button>

                    <a href="{{ route('tipo_carreras.tipo_carrera.index') }}" class="btn btn-primary"
                       title="Listar Tipo Carrera">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                    </a>

                    <a href="{{ route('tipo_carreras.tipo_carrera.create') }}" class="btn btn-secondary"
                       title="Crear  Tipo Carrera">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span>
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoCarrera->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Descripción</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoCarrera->description }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoCarrera->identifier }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Borrado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoCarrera->deleted_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoCarrera->created_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoCarrera->updated_at }}</dd>

            </dl>

        </div>
    </div>

@endsection
