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


    <div class="card-body p-0">
        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $request['seccion'] == 'mis_tickets' || !$request['seccion'] ? 'active' : '' }}" id="home-tab" data-bs-toggle="tab" data-bs-target="#mis_tickets" type="button" role="tab" aria-controls="mis_tickets" aria-selected="true">Mis tickets</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $request['seccion'] == 'asignados' ? 'active' : '' }}" id="profile-tab" data-bs-toggle="tab" data-bs-target="#asignados" type="button" role="tab" aria-controls="asignados" aria-selected="false">Asignados a mi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $request['seccion'] == 'derivados' ? 'active' : '' }}" id="derivados-tab" data-bs-toggle="tab" data-bs-target="#derivados" type="button" role="tab" aria-controls="derivados" aria-selected="false">Derivados a mi sección</button>
            </li>
            @if(Session::has('admin') || Session::has('avisos'))
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $request['seccion'] == 'todos' ? 'active' : '' }}" id="todos-tab" data-bs-toggle="tab" data-bs-target="#todos" type="button" role="tab" aria-controls="todos" aria-selected="false">Todos</button>
            </li>
            @endif
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade {{ $request['seccion'] == 'mis_tickets' || !$request['seccion'] ? 'show active' : '' }}" id="mis_tickets" role="tabpanel" aria-labelledby="home-tab">
                <div class="list-group">
                    @include('tickets.tickets.tables.tickets',['tickets'=>$misTickets,'seccion'=>'mis_tickets'])
                </div>
            </div>
            <div class="tab-pane fade {{ $request['seccion'] == 'asignados' ? 'show active' : '' }}" id="asignados" role="tabpanel" aria-labelledby="profile-tab">
                <div class="list-group">
                    @include('tickets.tickets.tables.tickets',['tickets'=>$asignados,'seccion'=>'asignados'])
                </div>
            </div>
            <div class="tab-pane fade {{ $request['seccion'] == 'derivados' ? 'show active' : '' }}" id="derivados" role="tabpanel" aria-labelledby="derivados-tab">
                <div class="list-group">
                    @include('tickets.tickets.tables.tickets',['tickets'=>$derivados,'seccion'=>'derivados'])
                </div>
            </div>
            <div class="tab-pane fade {{ $request['seccion'] == 'todos' ? 'show active' : '' }}" id="todos" role="tabpanel" aria-labelledby="todos-tab">
                <div class="list-group">
                    @include('tickets.tickets.tables.tickets',['tickets'=>$todos,'seccion'=>'todos'])
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
@endsection