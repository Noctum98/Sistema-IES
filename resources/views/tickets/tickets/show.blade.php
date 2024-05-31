@extends('layouts.app-prueba')

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Ticket' }}</h4>
        <div>
            <form method="POST" action="{!! route('tickets.ticket.destroy', $ticket->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('tickets.ticket.edit', $ticket->id ) }}" class="btn btn-primary" title="Edit Ticket">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Ticket" onclick="return confirm(&quot;Click Ok to delete Ticket.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                </button>

                <a href="{{ route('tickets.ticket.index') }}" class="btn btn-primary" title="Show All Ticket">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                </a>

                <a href="{{ route('tickets.ticket.create') }}" class="btn btn-secondary" title="Create New Ticket">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Usuario Responsable:</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($ticket->user)->nombre.' '.optional($ticket->user)->apellido }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Estado:</dt>
            <dd class="col-lg-10 col-xl-9">@include('componentes.tickets.colorEstado',['estado'=>$ticket->estado])</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Asunto:</dt>
            <dd class="col-lg-10 col-xl-9">{{ $ticket->asunto }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Descripcion:</dt>
            <dd class="col-lg-10 col-xl-9">{!! $ticket->descripcion !!}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Captura:</dt>
            <dd class="col-lg-10 col-xl-9">
                <a class="btn btn-sm btn-primary" href="{{ route('tickets.captura',$ticket->id) }}" target="_blank">Ver captura</a>
            </dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Url:</dt>
            <dd class="col-lg-10 col-xl-9"><a href="{{ $ticket->url }}" target="_blank" rel="noopener noreferrer">{{ $ticket->url }}</a></dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Creado:</dt>
            <dd class="col-lg-10 col-xl-9">{{ $ticket->created_at }}</dd>


        </dl>
        <div class="d-flex justify-content-end align-items-center p-3">

            @if(!$ticket->responsable)
            <div>
                <button class="btn btn-primary">Tomar ticket</button>
                <button class="btn btn-primary">Derivar ticket</button>
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Cambiar Estado
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection