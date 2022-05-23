<!-- Modal -->
<div class="modal fade" id="crearCargo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Cargo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cargo.store') }}" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="carrera_id">Carrera</label>
                        <select name="carrera_id" id="carrera_id" class="form-select">
                            <option value="">Seleccione carrera</option>
                            @foreach($carreras as $carrera)
                                <option
                                    value="{{ $carrera->id }}">{{ $carrera->nombre.' - '.$carrera->sede->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" type="button" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
