<!------------------
<div class="modal fade" id="rolesModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Cambiar sede de {{$user->nombre}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('sede_usuario',['id'=>$user->id])}}" method="POST">
                    @csrf
                    @foreach($sedes as $sede)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sede" id="exampleRadios{{$sede->id}}" value="{{$sede->id}}">
                        <label class="form-check-label" for="exampleRadios{{$sede->id}}">
                            {{$sede->nombre}}
                        </label>
                    </div>
                    @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <input type="submit" class="btn btn-primary" value="Guardar cambios">
            </div>
            </form>
        </div>

    </div>
</div>

-------------------------------------------------------------------------------------->
<!-- Modal -->
<div class="modal fade" id="rolesModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Roles</h5>
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
                    <hr>
                    @foreach($roles_secundarios as $rol)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $rol->nombre }}" id="rol-{{ $rol->id }}" {{ $user->hasRole($rol->nombre) ? 'checked':null }}>
                        <label class="form-check-label" for="rol-{{ $rol->id }}">
                            {{ $rol->descripcion }}
                        </label>
                    </div>
                    @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>