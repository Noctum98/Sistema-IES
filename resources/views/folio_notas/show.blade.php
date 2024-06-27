@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($title) ? $title : 'Nota' }}</h4>
            <div>
                <form method="POST" action="{!! route('folio_notas.folio_nota.destroy', $folioNota->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('folio_notas.folio_nota.edit', $folioNota->id ) }}" class="btn btn-primary"
                       title="Editar Nota">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Folio Nota"
                            onclick="return confirm('Aceptar para eliminar la nota')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                    </button>

                    <a href="{{ route('folio_notas.folio_nota.index') }}" class="btn btn-primary"
                       title="Ver todas las Notas">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                    </a>

                    <a href="{{ route('folio_notas.folio_nota.create') }}" class="btn btn-secondary"
                       title="Agregar Nota">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Acta Volante</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($folioNota->ActasVolante)->id }}</dd>

                <dt class="text-lg-end col-lg-2 col-xl-3">Folio</dt>
                <dd class="col-lg-10 col-xl-9">
                    {{ optional($folioNota->MesaFolio)->libro() }} /
                    {{ optional($folioNota->MesaFolio)->numero }}
                </dd>

                <dt class="text-lg-end col-lg-2 col-xl-3">Orden</dt>
                <dd class="col-lg-10 col-xl-9">{{ $folioNota->orden }}</dd>

                <dt class="text-lg-end col-lg-2 col-xl-3">Permiso</dt>
                <dd class="col-lg-10 col-xl-9">{{ $folioNota->permiso }}</dd>

                <dt class="text-lg-end col-lg-2 col-xl-3">Alumno</dt>
                <dd class="col-lg-10 col-xl-9">
                    {{ optional($folioNota->Alumno)->dni }}
                    {{ optional($folioNota->Alumno)->getApellidosNombres() }}
                </dd>

                <dt class="text-lg-end col-lg-2 col-xl-3">Escrito</dt>
                <dd class="col-lg-10 col-xl-9">{{ $folioNota->escrito }}</dd>

                <dt class="text-lg-end col-lg-2 col-xl-3">Oral</dt>
                <dd class="col-lg-10 col-xl-9">{{ $folioNota->oral }}</dd>

                <dt class="text-lg-end col-lg-2 col-xl-3">Calificación <br/> Definitiva</dt>
                <dd class="col-lg-10 col-xl-9">{{ $folioNota->definitiva }}</dd>

                <dt class="text-lg-end col-lg-2 col-xl-3">Agregado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $folioNota->created_at }}</dd>

                @if($folioNota->updated_at != $folioNota->created_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizada</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $folioNota->updated_at }}</dd>
                @endif

                @if($folioNota->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Eliminada</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $folioNota->deleted_at }}</dd>
                @endif

                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($folioNota->User)->getApellidoNombre() }}</dd>
            </dl>
        </div>
    </div>

@endsection
