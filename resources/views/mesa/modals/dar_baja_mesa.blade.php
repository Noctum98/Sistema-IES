<div class="modal fade" id="baja{{$inscripcion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Motivo de baja</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('mesa.borrar',['id'=>$inscripcion->id,'instancia_id'=>$inscripcion->instancia_id ? $inscripcion->instancia_id : $mesa->instancia_id]) }}">
                    @csrf
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="motivos[]" id="motivo_correlatividad" value="Falta de correlatividad" >
                        <label class="form-check-label" for="motivo_correlatividad">
                            Falta de correlatividad
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="motivos[]" id="materia_no_regular" value="Materia no regular" >
                        <label class="form-check-label" for="materia_no_regular">
                            Materia no regular
                        </label>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="motivo_opcional">Otro motivo (opcional):</label>
                        <textarea name="motivos[]" id="motivo_opcional" cols="10" rows="3" class="form-control"></textarea>
                    </div>
                    
                    @if($inscripcion->acta_volante)
                    <div class="alert alert-danger">
                        El alumno ya tiene una nota cargada en el acta volante, no se puede eliminar esta inscripción.
                    </div>
                    @endif
                    <input type="submit" class="btn btn-danger" value="Dar baja" {{ $inscripcion->acta_volante ? 'disabled' : '' }}>
                </form>
            </div>
        </div>
    </div>
</div>
