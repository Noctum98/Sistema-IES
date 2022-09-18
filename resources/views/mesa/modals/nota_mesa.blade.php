<div class="modal fade" id="nota{{$inscripcion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Nota de Mesa</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ !$inscripcion->acta_volante ? route('actas_volantes.store') :  route('actas_volantes.update',$inscripcion->acta_volante->id)}}" method="POST">
                    @if($inscripcion->acta_volante)
                        {{ METHOD_FIELD('PUT') }}
                    @endif    
                    <div class="form-group">
                        <label for="nota_escrito">Escrito</label>
                        <input type="number" name="nota_escrito" class="form-control" value="{{ $inscripcion->acta_volante ? $inscripcion->acta_volante->nota_escrito : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="nota_escrito">Oral</label>
                        <input type="number" name="nota_oral" class="form-control" value="{{ $inscripcion->acta_volante ? $inscripcion->acta_volante->nota_oral : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="nota_escrito">Porcentaje</label>
                        <input type="number" name="promedio" class="form-control" value="{{ $inscripcion->acta_volante ? $inscripcion->acta_volante->promedio : '' }}">
                    </div>
                    <div>
                        <input type="hidden" name="instancia_id" value="{{$instancia->id}}">
                        <input type="hidden" name="materia_id" value="{{$inscripcion->materia_id}}">
                        <input type="hidden" name="alumno_id" value="{{$inscripcion->alumno_id}}">
                        <input type="hidden" name="mesa_alumno_id" value="{{$inscripcion->id}}">
                    </div>
                    <input type="submit" value="Guardar" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>