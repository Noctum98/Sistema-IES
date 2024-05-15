@extends('layouts.app-prueba')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Materias Correlativas Cursado' }}</h4>
        <div>
            <form method="POST" action="{!! route('materias_correlativas_cursados.materias_correlativas_cursado.destroy', $materiasCorrelativasCursado->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('materias_correlativas_cursados.materias_correlativas_cursado.edit', $materiasCorrelativasCursado->id ) }}" class="btn btn-primary" title="Edit Materias Correlativas Cursado">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Borrar Materias Correlativas Cursado" onclick="return confirm(&quot;Click Ok para borrar Materias Correlativas Cursado.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('materias_correlativas_cursados.materias_correlativas_cursado.index') }}" class="btn btn-primary" title="Listar Materias Correlativas Cursado">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('materias_correlativas_cursados.materias_correlativas_cursado.create') }}" class="btn btn-secondary" title="Crear  Materias Correlativas Cursado">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Materia</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($materiasCorrelativasCursado->Materia)->correlativa }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Previa</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($materiasCorrelativasCursado->Materia)->correlativa }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($materiasCorrelativasCursado->User)->username }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Deleted At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $materiasCorrelativasCursado->deleted_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $materiasCorrelativasCursado->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Actua</dt>
            <dd class="col-lg-10 col-xl-9">{{ $materiasCorrelativasCursado->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection
