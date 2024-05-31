@extends('layouts.app-prueba')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Tickets</h4>
            <div>
                <a href="{{ route('tickets.ticket.create') }}" class="btn btn-secondary" title="Create New Ticket">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>
        
        @if(count($tickets) == 0)
            <div class="card-body text-center">
                <h4>No Tickets Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Asunto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td class="align-middle">{{ optional($ticket->user)->username }}</td>
                            <td class="align-middle">@include('componentes.tickets.colorEstado',['estado'=>$ticket->estado])</td>
                            <td class="align-middle">{{ $ticket->asunto }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('tickets.ticket.destroy', $ticket->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('tickets.ticket.show', $ticket->id ) }}" class="btn btn-info" title="Show Ticket">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span> Ver
                                        </a>

                                        @if(Session::has('admin'))
                                        <a href="{{ route('tickets.ticket.edit', $ticket->id ) }}" class="btn btn-primary" title="Edit Ticket">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                                        </a>
                                        
                                        <button type="submit" class="btn btn-danger" title="Delete Ticket" onclick="return confirm(&quot;Click Ok to delete Ticket.&quot;)">
                                            <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                                        </button>
                                        @endif
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            {!! $tickets->links('pagination') !!}
        </div>
        
        @endif
    
    </div>
@endsection