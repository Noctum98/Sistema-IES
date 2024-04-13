@extends('layouts.app-prueba')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Aviso' }}</h4>
        <div>
            <form method="POST" action="{!! route('aviso.aviso.destroy', $aviso->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('aviso.aviso.edit', $aviso->id ) }}" class="btn btn-primary" title="Edit Aviso">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Aviso" onclick="return confirm(&quot;Click Ok to delete Aviso.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('aviso.aviso.index') }}" class="btn btn-primary" title="Show All Aviso">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('aviso.aviso.create') }}" class="btn btn-secondary" title="Create New Aviso">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Creador</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($aviso->User)->activo }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Mensaje</dt>
            <dd class="col-lg-10 col-xl-9">{!! $aviso->mensaje !!}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Role Destinatario</dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->role_destinatario }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->updated_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Visible Desde</dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->visible_desde }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Visible Hasta</dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->visible_hasta }}</dd>

        </dl>

    </div>
</div>

@endsection
