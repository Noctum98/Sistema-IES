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
                    <div class="form-group">
                        <select name="rol_id" id="rol_id" class="form-select">
                            @foreach($roles_primarios as $rol)
                            <option value="{{ $rol->id }}" data-descripcion="{{ $rol->descripcion }}">{{ $rol->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group d-none" id="form_carrera_roles">
                        <label for="carrera_id_roles">Carrera</label>
                        <select name="carrera_id" id="carrera_id_roles" class="form-select carreras" disabled>
                            <option value="">- Selecciona la carrera -</option>
                            @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group d-none" id="form_materia_roles">
                        <label for="materia_id_roles">Materia</label>
                        <select name="materia_id" id="materia_id_roles" class="form-select materias " disabled>

                        </select>
                    </div>


                    @foreach($user->roles_primarios as $rol)

                    <div class="list-group">
                        @if($rol->rol->tipo == 0)
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $rol->rol->descripcion }}</h5>
                            </div>
                            @if($rol->carrera_id)
                                <p class="mb-1">Carrera ID: {{ $rol->carrera->nombre }}</p>
                                @endif
                                @if($rol->materia_id)
                                <p class="mb-1">Materia ID: {{ $rol->materia->nombre }}</p>
                                @endif
                        </a>
                        @endif
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