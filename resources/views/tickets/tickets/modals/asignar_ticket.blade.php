<div class="modal fade" id="asignarTicket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Asignar Ticket N°: {{ $ticket->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <form action="{{ route('asignaciones_tickets.store') }}" method="POST" class="row" id="formDerivar">
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                        <input type="hidden" name="derivacion_id" value="{{ $ticket->last_derivacion->id }}">
                        <div class="form-group col-md-12">
                            <label for="user_id">Usuario a asignar</label>
                            <select name="user_id" id="user_id" class="form-select">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if(Auth::user()->id == $user->id) selected @endif>{{ $user->nombre.' '.$user->apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="submitAsignar">Asignar</button>
                </form>

            </div>
        </div>
    </div>
</div>