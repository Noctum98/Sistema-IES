@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($libroPapel->name) ? $libroPapel->name : 'Libro Papel' }}</h4>
            <div>
                <form method="POST" action="{!! route('libro_papel.libro_papel.destroy', $libroPapel->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('libro_papel.libro_papel.edit', $libroPapel->id ) }}" class="btn btn-primary"
                       title="Editar Libro Papel">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Libro Papel"
                            onclick="return confirm('Aceptar para eliminar libro papel.')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                    </button>

                    <a href="{{ route('libro_papel.libro_papel.index') }}" class="btn btn-primary"
                       title="Listado Libro Papel">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                    </a>

                    <a href="{{ route('libro_papel.libro_papel.create') }}" class="btn btn-secondary"
                       title="Agregar Libro Papel">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $libroPapel->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Número</dt>
                <dd class="col-lg-10 col-xl-9">
                    {{ $libroPapel->number }} / {{ $libroPapel->roman }}
                </dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Acta Inicio</dt>
                <dd class="col-lg-10 col-xl-9">{!!  $libroPapel->acta_inicio !!}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador Inicio</dt>
                <dd class="col-lg-10 col-xl-9">{{ $libroPapel->operador_inicio }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Fecha Inicio</dt>
                <dd class="col-lg-10 col-xl-9">{{ $libroPapel->fecha_inicio }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Sede</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($libroPapel->sede)->nombre }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">User</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($libroPapel->user)->getApellidoNombre() }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $libroPapel->created_at }}</dd>

                @if($libroPapel->created_at != $libroPapel->updated_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $libroPapel->updated_at }}</dd>
                @endif
                @if($libroPapel->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Deleted At</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $libroPapel->deleted_at }}</dd>
                @endif
            </dl>
        </div>
    </div>

@endsection
