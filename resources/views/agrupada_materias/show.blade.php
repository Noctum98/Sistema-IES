@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($title) ? $title : 'Materia Agrupada ' }}</h4>
            <div>
                <form method="POST"
                      action="{!! route('agrupada_materias.agrupada_materia.destroy', $agrupadaMateria->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('agrupada_materias.agrupada_materia.edit', $agrupadaMateria->id ) }}"
                       class="btn btn-primary" title="Editar Materia Agrupada ">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar Materia Agrupada "
                            onclick="return confirm('¿Estas seguro de Borrar Agrupada Materia.?')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Borrar
                    </button>

                    <a href="{{ route('agrupada_materias.agrupada_materia.index') }}" class="btn btn-primary"
                       title="Listar Materias Agrupadas">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                    </a>

                    <a href="{{ route('agrupada_materias.agrupada_materia.create') }}" class="btn btn-secondary"
                       title="Agregar Materia Agrupada">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Correlatividad Agrupada</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($agrupadaMateria->CorrelatividadAgrupada)->Name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creada</dt>
                <dd class="col-lg-10 col-xl-9">{{ $agrupadaMateria->created_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Eliminada</dt>
                <dd class="col-lg-10 col-xl-9">{{ $agrupadaMateria->deleted_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Deshabilitada</dt>
                <dd class="col-lg-10 col-xl-9">{{ ($agrupadaMateria->disabled) ? 'Si' : 'No' }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Materia</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($agrupadaMateria->MasterMateria)->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Actualizada</dt>
                <dd class="col-lg-10 col-xl-9">{{ $agrupadaMateria->updated_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($agrupadaMateria->user)->username }}</dd>

        </dl>

    </div>
</div>

@endsection
