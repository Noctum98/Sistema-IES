@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($title) ? $title : 'Tipo Materia' }}</h4>
            <div>
                <form method="POST" action="{!! route('tipo_materias.tipo_materia.destroy', $tipoMateria->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('tipo_materias.tipo_materia.edit', $tipoMateria->id ) }}" class="btn btn-primary"
                       title="Editar Tipo Materia">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Eliminar Tipo Materia"
                            onclick="return confirm('Aceptar para eliminar el Tipo Materia')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                    </button>

                    <a href="{{ route('tipo_materias.tipo_materia.index') }}" class="btn btn-primary"
                       title="Listar Tipo Materia">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listar
                    </a>

                    <a href="{{ route('tipo_materias.tipo_materia.create') }}" class="btn btn-secondary"
                       title="Agregar Tipo Materia">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">

                <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoMateria->identificador }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoMateria->nombre }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $tipoMateria->created_at }}</dd>
                @if($tipoMateria->created_at !=$tipoMateria->updated_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $tipoMateria->updated_at }}</dd>
                @endif
                @if($tipoMateria->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Eliminado</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $tipoMateria->deleted_at }}</dd>
                @endif
            </dl>

        </div>
    </div>

@endsection
