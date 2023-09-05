<div class="modal fade" id="edit{{$equivalencia->id}}" tabindex="-1" role="dialog"
     aria-labelledby="equivalenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="equivalenciaModalLabel">Editar equivalencia</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('equivalencias.update',['equivalencia'=>$equivalencia->id])}}">
                    @csrf
                    <div class="form-group">
                        <label for="nota">Nota</label>
                        <input type="number" name="nota" id="nota" class="form-control" value="{{$equivalencia->nota}}"
                               required/>
                    </div>
                    <div class="form-group">
                        <label for="resolution">N° Resolución</label>
                        <input type="text" name="resolution" id="resolution" class="form-control"
                               value="{{$equivalencia->resolution}}" required/>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha Resolución</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{$equivalencia->fecha}}"
                               required/>
                    </div>
                    <input type="hidden" name="alumno_id" value="{{$alumno->id}}" id="alumno_id-{{$alumno->id}}">
                    <div class="form-check">
                        <input class="form-check-input" name="flexCheckCohorte" type="checkbox" value="true" id="flexCheckCohorte">
                        <label class="form-check-label" for="flexCheckCohorte">
                            Ajusta cohorte
                        </label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
