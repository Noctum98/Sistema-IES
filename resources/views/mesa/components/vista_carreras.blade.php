<form action="{{ route('modulo_profesor.vincular_cargo_modulo') }}" method="POST">
    <input type="hidden" name="cargo_id" value="{{ $cargo->id }}">
    <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
    <div class="form-group">
        <label for="materia_id">Módulos</label>
        <select name="materia_id[]  " id="materia_id" class="form-select" multiple>
            @foreach($cargo->materias as $materia)
                <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>
