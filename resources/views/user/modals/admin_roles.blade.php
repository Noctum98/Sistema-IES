<!-- Modal -->
<div class="modal fade" id="rolesModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Administrar Roles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('set_roles',$user->id) }}" method="POST">
                    @foreach($roles_primarios as $rol)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $rol->nombre }}" id="rol-{{ $rol->id }}" {{ $user->hasRole($rol->nombre) ? 'checked':null }}>
                        <label class="form-check-label" for="rol-{{ $rol->id }}">
                            {{ $rol->descripcion }}
                        </label>
                    </div>
                    @endforeach
                    @if(isset($roles_secundarios) && $roles_secundarios)
                    <hr>

                    @foreach($roles_secundarios as $rol)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $rol->nombre }}" id="rol-{{ $rol->id }}" {{ $user->hasRole($rol->nombre) ? 'checked':null }}>
                        <label class="form-check-label" for="rol-{{ $rol->id }}">
                            {{ $rol->descripcion }}
                        </label>
                    </div>
                    @endforeach
                    @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
