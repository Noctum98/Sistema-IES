<div class="modal fade" id="cargosModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Administrar Cargos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('set_cargos_carreras',$user->id) }}" method="POST">
                    <div class="form-group">
                        <label for="carreras-cargo">Cargos</label>
                        <select name="carrera" id="carreras-cargo" class="form-select carreras-cargo">
                            <option selected='selected' value=''> - Seleccione Carrera -</option>

                            @foreach($carreras as $carrera)
                                @if(count($carrera->cargos) > 0)
                                    <option
                                        value="{{ $carrera->id }}">{{ $carrera->nombre.' - '.$carrera->sede->nombre }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cargos">Cargos</label>
                        <select name="cargo" id="cargos" class="form-select cargos">

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
