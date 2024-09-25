@extends('layouts.app-prueba')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Categorias Tickets' }}</h4>
        <div>
            <form method="POST" action="{!! route('categorias_tickets.categorias_tickets.destroy', $categoriasTickets->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('categorias_tickets.categorias_tickets.edit', $categoriasTickets->id ) }}" class="btn btn-primary" title="Edit Categorias Tickets">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Categorias Tickets" onclick="return confirm(&quot;Click Ok to delete Categorias Tickets.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('categorias_tickets.categorias_tickets.index') }}" class="btn btn-primary" title="Show All Categorias Tickets">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('categorias_tickets.categorias_tickets.create') }}" class="btn btn-secondary" title="Create New Categorias Tickets">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
            <dd class="col-lg-10 col-xl-9">{{ $categoriasTickets->nombre }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Horas De Espera</dt>
            <dd class="col-lg-10 col-xl-9">{{ $categoriasTickets->horas_de_espera }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $categoriasTickets->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $categoriasTickets->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection