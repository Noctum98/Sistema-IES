<div class="modal fade" id="carrerasModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Asignar Carreras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('set_carrera',$user->id) }}" method="POST">
                    <div class="form-group">
                        <label for="carreras">Carreras</label>
                        <select name="carrera_id" id="carreras" class="form-select carreras">
                            <option selected='selected' value=''> - Seleccione Carrera -</option>
                            @foreach($user->sedes as $sede)
                                @foreach($sede->carreras as $carrera)
                                    <option
                                        value="{{ $carrera->id }}">{{ $carrera->nombre.' ( '.$carrera->resolucion.' '.$carrera->turno.' ) '.' - '.$sede->nombre }}</option>
                                @endforeach
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
