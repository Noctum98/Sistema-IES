<div class="modal fade" id="derivarTicket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Derivar Ticket N°: {{ $ticket->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <form action="{{ route('derivaciones_tickets.store') }}" method="POST" class="row" id="formDerivar">
                        <input type="hidden" name="operador_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                        <div class="form-group col-md-12">
                            <label for="rol_id">Sección/Rol</label>
                            <select name="rol_id" id="rol_id" class="form-select">
                                @foreach($roles as $i => $rol)
                                <option value="{{ $i }}">{{ $rol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="form-check ">
                                <input class="form-check-input" name="general" type="checkbox" value="1" id="derivacionGeneral">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Derivación General
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="sede_id">Sede</label>
                            <select name="sede_id" id="sede_id" class="form-select" required>
                                <option value="">- Selecciona la sede -</option>
                                @foreach($sedes as $i => $sede)
                                <option value="{{ $i }}">{{ $sede }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="carrera_id">Carrera</label>
                            <select name="carrera_id" id="carrera_id" class="form-select" required disabled>

                            </select>
                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="submitDerivar">Derivar</button>
            </div>
        </div>
    </div>
</div>