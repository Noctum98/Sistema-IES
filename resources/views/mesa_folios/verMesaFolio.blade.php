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
              <x-dl-mesa-folio :mesaFolio="$mesaFolio"/>
            </dl>

            <a href="{{ route('folio_notas.folio_nota.carga_actas-volantes', [
    'mesaFolio'=> $mesaFolio->id, 'libro' => $libro->id
]) }}" class="btn btn-primary"
            >Cargar Notas de Actas Volantes
            </a>

        </div>
    </div>

@endsection
