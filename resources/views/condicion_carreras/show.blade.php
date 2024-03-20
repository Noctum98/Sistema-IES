@extends('layouts.app-prueba')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Condicion Carrera' }}</h4>
        <div>
            <form method="POST" action="{!! route('condicion_carreras.condicion_carrera.destroy', $condicionCarrera->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('condicion_carreras.condicion_carrera.edit', $condicionCarrera->id ) }}" class="btn btn-primary" title="Edit Condicion Carrera">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Condicion Carrera" onclick="return confirm(&quot;Click Ok to delete Condicion Carrera.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('condicion_carreras.condicion_carrera.index') }}" class="btn btn-primary" title="Show All Condicion Carrera">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('condicion_carreras.condicion_carrera.create') }}" class="btn btn-secondary" title="Create New Condicion Carrera">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
            <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->nombre }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
            <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->identificador }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Habilitado</dt>
            <dd class="col-lg-10 col-xl-9">{{ ($condicionCarrera->habilitado) ? 'Yes' : 'No' }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($condicionCarrera->User)->username }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Deleted At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->deleted_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection
