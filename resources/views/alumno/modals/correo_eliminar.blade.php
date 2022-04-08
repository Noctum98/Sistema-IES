<div class="modal fade" id="eliminarMatriculacionModal{{$carrera->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Eliminar matriculación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('matriculacion.delete',['id'=>$alumno->id,'carrera_id'=>$carrera->id]) }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <h6>Error en:</h6>
                    <div class="form-check m-0 p-0">
                        <input type="checkbox" name="errores[]" id="sede" class="form-checkbox" value="Unidad Académica">
                        <label for="sede">Unidad Académica</label>
                    </div>
                    <div class="form-check m-0 p-0">
                        <input type="checkbox" name="errores[]" id="carrera" class="form-checkbox" value="Carrera">
                        <label for="carrera">Carrera</label>
                    </div>
                    <div class="form-check m-0 p-0">
                        <input type="checkbox" name="errores[]" id="año" class="form-checkbox" value="Año">
                        <label for="año">Año</label>
                    </div>
                    <div class="form-group">
                        <label for="motivo">Otro motivo (opcional): </label>
                        <textarea name="motivo" id="motivo" cols="20" rows="5" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar matriculación</button>
                    <button type="button" class="btn btn-sm btn-warning" data-bs-dismiss="modal">Cerrar</button>

                </form>
            </div>

        </div>
    </div>
</div>