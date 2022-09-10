<div class="modal fade" id="agregarCargo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Módulos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('modulos.agregarCargo') }}" method="POST">
                    <input type="hidden" name="materia" value="{{ $modulo->id }}">
                    <div class="form-group">
                        <label for="carreras">Cargos</label>
                        <select name="cargo_id" id="cargo_id" class="form-select cargos">
                            @foreach($cargos as $cargo)
                                <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>