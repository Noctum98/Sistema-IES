
<div class="alert alert-info mt-3">
    {{$mensaje}}
</div>
<form method="GET" action="{{ route('tickets.ticket.index') }}" class="mt-1">
    <input type="hidden" value="{{ $seccion }}" name="seccion">
    <div class="row">
        <!-- Input de búsqueda -->
        <div class="col-md-4">
            <div class="input-group">
                <label class="input-group-text" for="categoria_id">Contenido</label>
                <input type="text" id="busqueda" name="{{$seccion}}_search" class="form-control" value="{{ isset($request[$seccion.'_search']) ?$request[$seccion.'_search']: '' }}" placeholder="Asunto o Contenido" aria-describedby="inputGroupPrepend2">

            </div>
        </div>

        <!-- Select de categoría -->
        <div class="col-md-4">
            <div class="input-group">
                <label class="input-group-text" for="categoria_id">Categoría</label>
                <select name="{{$seccion}}_categoria_id" id="categoria_id" class="form-select">
                    <option value="">Selecciona una categoría</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @if(isset($request[$seccion.'_categoria_id']) && $request[$seccion.'_categoria_id']==$categoria->id) selected @endif>{{$categoria->nombre}}</option>

                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <label class="input-group-text" for="estado_id">Estado</label>
                <select name="{{$seccion}}_estado_id" id="{{$seccion}}_estado_id" class="form-select">
                    <option value="">Selecciona un estado</option>
                    @foreach($estados as $estado)
                    <option value="{{ $estado->id }}" @if(isset($request[$seccion.'_estado_id']) && $request[$seccion.'_estado_id']==$estado->id) selected @endif>{{$estado->nombre}}</option>

                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <a href="{{ route('tickets.ticket.index') }}" class="col-md-3 btn btn-sm btn-warning"><i class="fas fa-sync"></i> Reestablecer</a>

            <button class="col-md-3 btn btn-sm btn-info" id="inputGroupPrepend2" type="submit"><i class="fa fa-search"></i>
                Buscar
            </button>
        </div>
    </div>
</form>
@if(count($tickets) == 0)
<div class="card-body text-center">
    <h4>No hay tickets disponibles.</h4>
</div>
@else
<div class="table-responsive">
    <table class="table table-striped mt-4" id="myTable">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Categoría</th>
                <th>Asunto</th>
                <th>Responsable</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            @foreach($tickets as $ticket)
            <tr>
                <td class="align-middle">{{ optional($ticket->user)->nombre.' '.optional($ticket->user)->apellido }}</td>
                <td class="align-middle">@include('componentes.tickets.colorEstado',['estado'=>$ticket->last_estado_ticket])</td>
                <td class="align-middle">{{ $ticket->categoria->nombre }}</td>
                <td class="align-middle">{{ $ticket->asunto }}</td>
                <td class="align-middle">{{ $ticket->responsable ? $ticket->responsable->user->nombre.' '.$ticket->responsable->user->apellido : 'Sin asignar' }}</td>
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
@endif


{{ $tickets->appends(['$seccion' => request($seccion.'_search')])->links() }}