@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($title) ? $title : 'Libro (Maestro)' }}</h4>
            <div>
                <form method="POST" action="{!! route('old_libros.old_libros.destroy', $oldLibros->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('old_libros.old_libros.edit', $oldLibros->id ) }}" class="btn btn-primary"
                       title="Editar Libro (Maestro)">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Eliminar Libro (Maestro)"
                            onclick="return confirm('Aceptar para eliminar Libro (Maestro)')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                    </button>

                    <a href="{{ route('old_libros.old_libros.index') }}" class="btn btn-primary"
                       title="Listar Libros (Maestros)">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listar
                    </a>

                    <a href="{{ route('old_libros.old_libros.create') }}" class="btn btn-secondary"
                       title="Agregar Libro (Maestro)">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Acta Inicio</dt>
                <dd class="col-lg-10 col-xl-9">{{ $oldLibros->acta_inicio }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Número</dt>
                <dd class="col-lg-10 col-xl-9">{{ $oldLibros->number }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">N° en Romanos</dt>
                <dd class="col-lg-10 col-xl-9">{{ $oldLibros->romanos }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Resoluciones</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($oldLibros->Resolucione)->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Fecha Inicio</dt>
                <dd class="col-lg-10 col-xl-9">{{ $oldLibros->fecha_inicio }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Sede</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($oldLibros->Sede)->nombre }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Resolucion Original</dt>
                <dd class="col-lg-10 col-xl-9">{{ $oldLibros->resolucion_original }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($oldLibros->User)->username }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Observaciones</dt>
                <dd class="col-lg-10 col-xl-9">{{ $oldLibros->observaciones }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">User</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($oldLibros->User)->username }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $oldLibros->created_at }}</dd>
                @if($oldLibros->updated_at != $oldLibros->created_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $oldLibros->updated_at }}</dd>
                @endif
                @if($oldLibros->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Eliminado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $oldLibros->deleted_at }}</dd>
                @endif

            </dl>

        </div>
    </div>

@endsection
