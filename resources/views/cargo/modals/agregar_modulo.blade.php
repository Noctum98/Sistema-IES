<div class="modal fade" id="agregarModulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Modulos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cargo.agregarModulo') }}" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="cargo_id" value="{{ $cargo->id }}">
                        <label for="carreras">Carreras</label>
                        <select name="carrera" id="carreras" class="form-select carreras">
                            @foreach($sedes as $sede)
                                @foreach($sede->carreras as $carrera)
                                <option value="{{ $carrera->id }}">{{ $carrera->nombre.' - '.$sede->nombre }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="carreras">Modulos</label>
                        <select name="materia" id="materias" class="form-select materias">

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