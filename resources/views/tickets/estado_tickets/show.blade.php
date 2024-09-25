@extends('layouts.app-prueba')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Estado Ticket' }}</h4>
        <div>
            <form method="POST" action="{!! route('estado_tickets.estado_ticket.destroy', $estadoTicket->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('estado_tickets.estado_ticket.edit', $estadoTicket->id ) }}" class="btn btn-primary" title="Edit Estado Ticket">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Estado Ticket" onclick="return confirm(&quot;Click Ok to delete Estado Ticket.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                </button>

                <a href="{{ route('estado_tickets.estado_ticket.index') }}" class="btn btn-primary" title="Show All Estado Ticket">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                </a>

                <a href="{{ route('estado_tickets.estado_ticket.create') }}" class="btn btn-secondary" title="Create New Estado Ticket">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
            <dd class="col-lg-10 col-xl-9">{{ $estadoTicket->nombre }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
            <dd class="col-lg-10 col-xl-9">{{ $estadoTicket->identificador }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $estadoTicket->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated At</dt>
            <dd class="col-lg-10 col-xl-9">{{ $estadoTicket->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection