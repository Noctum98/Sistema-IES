@extends('layouts.app')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Libros' }}</h4>
        <div>
            <form method="POST" action="{!! route('libros.libros.destroy', $libros->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('libros.libros.edit', $libros->id ) }}" class="btn btn-primary" title="Edit Libros">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Libros" onclick="return confirm(&quot;Click Ok to delete Libros.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('libros.libros.index') }}" class="btn btn-primary" title="Show All Libros">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('libros.libros.create') }}" class="btn btn-secondary" title="Create New Libros">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $libros->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Folio</dt>
            <dd class="col-lg-10 col-xl-9">{{ $libros->folio }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Llamado</dt>
            <dd class="col-lg-10 col-xl-9">{{ $libros->llamado }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Mesa</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($libros->mesa)->cierre }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Numero</dt>
            <dd class="col-lg-10 col-xl-9">{{ $libros->numero }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Orden</dt>
            <dd class="col-lg-10 col-xl-9">{{ $libros->orden }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $libros->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection