@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">
  
         <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($title) ? $title : 'Estado Ticket' }}</h4>
            <div>
                <a href="{{ route('estado_tickets.estado_ticket.index') }}" class="btn btn-primary" title="Ver todos Estado Ticket">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                </a>

                <a href="{{ route('estado_tickets.estado_ticket.create') }}" class="btn btn-secondary" title="Crear Estado Ticket">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" class="needs-validation" novalidate action="{{ route('estado_tickets.estado_ticket.update', $estadoTicket->id) }}" id="edit_estado_ticket_form" name="edit_estado_ticket_form" accept-charset="UTF-8" >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('tickets.estado_tickets.form', [
                                        'estadoTicket' => $estadoTicket,
                                      ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Guardar">
                </div>
            </form>

        </div>
    </div>

@endsection