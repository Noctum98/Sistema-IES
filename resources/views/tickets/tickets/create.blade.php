@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

         <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Crear Ticket</h4>
            <div>
                <a href="{{ route('tickets.ticket.index') }}" class="btn btn-primary" title="Show All Ticket">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
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

            <form method="POST" class="needs-validation" novalidate action="{{ route('tickets.ticket.store') }}" accept-charset="UTF-8" id="create_ticket_form" name="create_ticket_form" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include ('tickets.tickets.form', [
                                        'ticket' => null,
                                      ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Enviar">
                </div>

            </form>

        </div>
    </div>

@endsection


