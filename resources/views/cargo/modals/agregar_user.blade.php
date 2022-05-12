<div class="modal fade" id="agregarUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cargo.agregarUser') }}" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="cargo_id" value="{{ $cargo->id }}">
                        <label for="user_id">Usuarios</label>
                        <select name="user_id" id="user_id" class="form-select carreras">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->nombre.'  '.$user->apellido }}</option>
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