<div class="modal fade" id="materiasModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Administrar Carreras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('set_materias_carreras',$user->id) }}" method="POST">
                    <div class="form-group">
                        <label for="carreras">Carreras</label>
                        <select name="carrera" id="carreras" class="form-select carreras">
                            <option selected='selected' value=''> - Seleccione Carrera -</option>
                            @foreach($carreras as $carrera)
                                @if(count($carrera->cargos) <= 0)
                                    <option
                                            value="{{ $carrera->id }}">{{ $carrera->nombre.' ( '.$carrera->resolucion.' '.$carrera->turno.' ) '.' - '.$carrera->sede->nombre }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="materias">Materias</label>
                        <select name="materia" id="materias" class="form-select materias">

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
