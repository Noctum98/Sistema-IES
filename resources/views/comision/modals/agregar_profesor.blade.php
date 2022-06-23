<div class="modal fade" id="agregarProfesor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Profesores</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('comision.profesor',$comision->id) }}" method="POST">
                    <input type="hidden" name="cargo_id" value="{{ $comision->id }}">
                    <div class="form-group">
                        <label for="carreras">Profesores</label>
                        <select name="profesor_id" id="profesor_id" class="form-select">
                                @foreach($profesores as $profesor)
                                    <option value="{{ $profesor->id }}">{{ $profesor->nombre.' '.$profesor->apellido }}</option>
                                @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>