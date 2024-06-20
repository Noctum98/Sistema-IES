@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($title) ? $title : 'Libro Digital' }}</h4>
            <div>
                <form method="POST" action="{!! route('libros_digitales.libros_digitales.destroy', $librosDigitales->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('libros_digitales.libros_digitales.edit', $librosDigitales->id ) }}" class="btn btn-primary"
                       title="Editar Libro Digital">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Eliminar Libro Digital"
                            onclick="return confirm('Aceptar para eliminar Libro Digital')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                    </button>

                    <a href="{{ route('libros_digitales.libros_digitales.index') }}" class="btn btn-primary"
                       title="Listar Libros Digitales">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listar
                    </a>

                    <a href="{{ route('libros_digitales.libros_digitales.create') }}" class="btn btn-secondary"
                       title="Agregar Libro Digital">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Acta Inicio</dt>
                <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->acta_inicio }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Número</dt>
                <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->number }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">N° en Romanos</dt>
                <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->romanos }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Resoluciones</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($librosDigitales->Resolucione)->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Fecha Inicio</dt>
                <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->fecha_inicio }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Sede</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($librosDigitales->Sede)->nombre }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Resolucion Original</dt>
                <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->resolucion_original }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($librosDigitales->User)->username }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Observaciones</dt>
                <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->observaciones }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">User</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($librosDigitales->User)->username }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->created_at }}</dd>
                @if($librosDigitales->updated_at != $librosDigitales->created_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->updated_at }}</dd>
                @endif
                @if($librosDigitales->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Eliminado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $librosDigitales->deleted_at }}</dd>
                @endif

            </dl>

        </div>
    </div>

@endsection
