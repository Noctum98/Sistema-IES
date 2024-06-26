@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($title) ? $title : 'Folio' }}</h4>
            <div>
                <form method="POST" action="{!! route('mesa_folios.mesa_folio.destroy', $mesaFolio->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('mesa_folios.mesa_folio.edit', $mesaFolio->id ) }}" class="btn btn-primary"
                       title="Editar Folio">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Mesa Folio"
                            onclick="return confirm('Aceptar para confirmar la eliminación')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                    </button>

                    <a href="{{ route('mesa_folios.mesa_folio.index') }}" class="btn btn-primary"
                       title="Ver todos los Folio">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                    </a>

                    <a href="{{ route('mesa_folios.mesa_folio.create') }}" class="btn btn-secondary"
                       title="Agregar Folio">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>
                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Fecha</dt>
                <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->fecha }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Libro Digital</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->LibrosDigitale)->acta_inicio }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Master Materia</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->MasterMateria)->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Mesa</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->Mesa)->cierre }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Turno</dt>
                <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->turno }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Numero</dt>
                <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->numero }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Presidente</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->presidente)->getApellidoNombre() }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Vocal 1</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->vocal1)->getApellidoNombre() }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Vocal 2</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->vacal2)->getApellidoNombre() }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Aprobados</dt>
                <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->aprobados }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Desaprobados</dt>
                <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->desaprobados }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Ausentes</dt>
                <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->ausentes }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Coordinador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->User)->activo }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($mesaFolio->User)->activo }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->created_at }}</dd>
                @if($mesaFolio->created_at != $mesaFolio->updated_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->updated_at }}</dd>
                @endif
                @if($mesaFolio->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Deleted At</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $mesaFolio->deleted_at }}</dd>
                @endif
            </dl>

        </div>
    </div>

@endsection
