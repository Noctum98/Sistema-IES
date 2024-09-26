@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ $title ?? 'Libro Digital' }}</h4>
            <div>
                <form method="POST" action="{!! route('libros_digitales.libro_digital.destroy', $libroDigital->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('libros_digitales.libro_digital.edit', $libroDigital->id ) }}"
                       class="btn btn-primary" title="Editar Libro Digital">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Eliminar Libro Digital"
                            onclick="return confirm('Aceptar para eliminar Libro Digital.')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                    </button>

                    <a href="{{ route('libros_digitales.libro_digital.index') }}" class="btn btn-primary"
                       title="Listado Libros Digitales">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                    </a>

                    <a href="{{ route('libros_digitales.libro_digital.create') }}" class="btn btn-secondary"
                       title="Agregar Libro Digital">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                @if(session()->has('admin') || session()->has('regente'))
                    <dt class="text-lg-end col-lg-2 col-xl-3">ID</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $libroDigital->id }}</dd>
                @endif
                <dt class="text-lg-end col-lg-2 col-xl-3">Número</dt>
                <dd class="col-lg-10 col-xl-9">{{ $libroDigital->number }} / {{ $libroDigital->romanos }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Resolución</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($libroDigital->resoluciones)->name }}</dd>
                    <dt class="text-lg-end col-lg-2 col-xl-3">N°</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($libroDigital->resoluciones)->resolution }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Libro Papel (físico)</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($libroDigital->LibrosPapele)->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Fecha Inicio</dt>
                <dd class="col-lg-10 col-xl-9">{{ $libroDigital->fecha_inicio }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Sede</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($libroDigital->sede)->nombre }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Observaciones</dt>
                <dd class="col-lg-10 col-xl-9">{{ $libroDigital->observaciones }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Usuario</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($libroDigital->user)->username }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $libroDigital->created_at }}</dd>
                @if($libroDigital->created_at !== $libroDigital->updated_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $libroDigital->updated_at }}</dd>
                @endif
                @if($libroDigital->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Eliminado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $libroDigital->deleted_at }}</dd>
                @endif
            </dl>


            <a href="{{ route('mesa_folios.mesa_folio.carga_folio_by_libro', [
    'libroDigital'=> $libroDigital->id,'mesa' => $libro->mesa, 'libro' => $libro->id
]) }}" class="btn btn-primary"
            >Cargar Folio
            </a>
        </div>
    </div>

@endsection
