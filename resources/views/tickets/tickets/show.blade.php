@extends('layouts.app-prueba')

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('js/editor_web/styles/simditor.css')}}" />

<div class="card text-bg-theme">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Ticket' }}</h4>
        @if($admin)
        <div>
            <form method="POST" action="{!! route('tickets.ticket.destroy', $ticket->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('tickets.ticket.edit', $ticket->id ) }}" class="btn btn-primary" title="Edit Ticket">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                </a>

                @if(Session::has('admin'))
                <button type="submit" class="btn btn-danger" title="Delete Ticket" onclick="return confirm(&quot;Click Ok to delete Ticket.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Eliminar
                </button>
                @endif

                <a href="{{ route('tickets.ticket.index') }}" class="btn btn-primary" title="Show All Ticket">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                </a>

                <a href="{{ route('tickets.ticket.create') }}" class="btn btn-secondary" title="Create New Ticket">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>

                @if(count($ticket->derivaciones) > 0)
                <a href="#" class="btn btn-info" id="modalHistorialDerivaciones" data-ticket="{{ $ticket->id }}" data-bs-toggle="modal" data-bs-target="#historialDerivaciones">
                    <i class="fas fa-history"></i> Historial de Derivaciones
                </a>
                @endif
            </form>
        </div>
        @endif
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Creador:</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($ticket->user)->nombre.' '.optional($ticket->user)->apellido }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Responsable:</dt>
            <dd class="col-lg-10 col-xl-9">{{ $ticket->responsable ? $ticket->responsable->user->nombre.' '.$ticket->responsable->user->apellido : 'Sin asignar' }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Estado:</dt>
            <dd class="col-lg-10 col-xl-9">@include('componentes.tickets.colorEstado',['estado'=>$ticket->last_estado_ticket])</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Asunto:</dt>
            <dd class="col-lg-10 col-xl-9">{{ $ticket->asunto }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Descripcion:</dt>
            <dd class="col-lg-10 col-xl-9">{!! $ticket->descripcion !!}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Captura:</dt>
            <dd class="col-lg-10 col-xl-9">
                @if($ticket->captura)
                <a class="btn btn-sm btn-primary" href="{{ route('tickets.captura',$ticket->id) }}" target="_blank">Ver captura</a>
                @else
                Sin captura
                @endif
            </dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Url:</dt>
            <dd class="col-lg-10 col-xl-9"><a href="{{ $ticket->url }}" target="_blank" rel="noopener noreferrer">{{ $ticket->url }}</a></dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Creado:</dt>
            <dd class="col-lg-10 col-xl-9">{{ $ticket->created_at }}</dd>


        </dl>

        @if($admin)
        <div class="d-flex justify-content-end align-items-center p-3 flex-row">

            <div class="d-flex">
                @if($ticket->derivaciones->count() > 0 && !$ticket->responsable)
                <form action="{{ route('asignaciones_tickets.store') }}" method="POST" class="mr-2">
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <input type="hidden" name="derivacion_id" value="{{ $ticket->last_derivacion->id }}">
                    <button type="submit" class="btn btn-primary">Tomar ticket</button>
                </form>
                @endif
                @if($ticket->derivaciones->count() > 0 && $ticket->responsable && $ticket->responsable->user_id  != Auth::user()->id)
                <form action="{{ route('asignaciones_tickets.store') }}" method="POST" class="mr-2">
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <input type="hidden" name="derivacion_id" value="{{ $ticket->last_derivacion->id }}">
                    <button type="submit" class="btn btn-primary">Tomar ticket</button>
                </form>
                @endif
                <button class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#derivarTicket">Derivar ticket</button>
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Cambiar Estado
                    </button>
                    <ul class="dropdown-menu">
                        <input type="hidden" id="param" value="{{ $ticket->id }}">
                        @foreach($estados as $i => $estado)
                        <form action="{{ route('tickets.changeEstado',$ticket->id) }}" id="updateEstado{{$i}}" method="POST">
                            {{ method_field('PUT') }}
                            <input type="hidden" name="estado_id" value="{{ $i }}">
                        </form>
                        <li><a class="dropdown-item estados" href="#" data-id="{{ $i }}">{{ $estado }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
        @endif
    </div>
</div>

<div class="card text-bg-theme mt-3">
    <div class="card-body">
        @if(count($ticket->respuestas) > 0)

        <dl class="row">
            @foreach($ticket->respuestas as $respuesta)

            <dt class="text-lg-end col-lg-2 col-xl-3">{{ $respuesta->user->nombre.' '.$respuesta->user->apellido }}</dt>
            <dd class="col-lg-10 col-xl-9 border-bottom">{!! $respuesta->contenido !!}
            </dd>

            @endforeach
        </dl>

        @endif

        @if($ticket->last_estado_ticket->identificador != 'cerrado' && $respuesta)
        <form action="{{ route('respuestas_tickets.store') }}" method="POST">
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <div class="mb-3 row">
                <label for="contenido" class="col-form-label text-lg-end col-lg-2 col-xl-3"><strong>Respuesta</strong></label>
                <div class="col-lg-10 col-xl-9">
                    <textarea class="{{ $errors->has('contenido') ? ' is-invalid' : '' }}" name="contenido" id="contenido" required="true" placeholder="Ingresa la descripción aqui...">{{ old('contenido') }}</textarea>
                    {!! $errors->first('contenido', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center p-3 flex-row">
                <input type="submit" value="Enviar respuesta" class="btn btn-primary">

            </div>
        </form>
        @endif
    </div>
</div>
<script>
    Simditor.locale = 'es-AR';
    let editor = new Simditor({
        textarea: $('#contenido'),
        toolbar: [
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'fontScale',
            'color',
            'ol',
            'ul',
            'blockquote',
            'code',
            'table',
            'link',
            'hr',
            'indent',
            'outdent'
        ]
    });

    /*
    $(document).ready(function () {


        $('#role_destinatario').select2({
            width: "50%",
            placeholder: "Seleccione roles para el mensaje"

        });

    });*/
</script>
@include('tickets.tickets.modals.derivar_ticket')
@include('tickets.tickets.modals.historial_derivaciones')

@endsection
@section('scripts')
<script src="{{ asset('js/tickets/ticket.js') }}"></script>
<script src="{{ asset('js/tickets/historial_derivaciones.js') }}"></script>
<script src="{{asset('js/editor_web/scripts/module.js')}}"></script>
<script src="{{asset('js/editor_web/scripts/hotkeys.js')}}"></script>
<script src="{{asset('js/editor_web/scripts/simditor.js')}}"></script>

@endsection
