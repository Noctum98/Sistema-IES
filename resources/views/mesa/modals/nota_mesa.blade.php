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
                <p class="text-danger"><i>Si solo quiere poner una sola nota debe colocar un guión medio en el campo que no corresponde la nota.</i></p>
                <form action="{{ !$inscripcion->acta_volante ? route('actas_volantes.store') :  route('actas_volantes.update',$inscripcion->acta_volante->id)}}" method="POST" >
                    @if($inscripcion->acta_volante)
                    {{ METHOD_FIELD('PUT') }}
                    @endif
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="ausente" name="ausente" data-id="{{$inscripcion->id}}" {{ $cierre ? 'disabled' : '' }}>
                        <label class="form-check-label" for="ausente">
                            Marcar como AUSENTE
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="nota_escrito">Escrito</label>
                        @if($inscripcion->acta_volante)
                        <input type="text" name="nota_escrito" class="form-control" id="escrito-{{$inscripcion->id}}" data-id="{{$inscripcion->id}}" value="{{ $inscripcion->acta_volante->nota_escrito != -1 ? $inscripcion->acta_volante->nota_escrito : 'A' }}" {{ $cierre ? 'disabled' : '' }} pattern="(^[Aa]$)|([-]$)|([0-9]{1,2})">
                        @else
                        <input type="text" name="nota_escrito" class="form-control" id="escrito-{{$inscripcion->id}}" data-id="{{$inscripcion->id}}" {{ $cierre ? 'disabled' : '' }}>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="nota_escrito">Oral</label>
                        @if($inscripcion->acta_volante)
                        <input type="text" name="nota_oral" class="form-control" id="oral-{{$inscripcion->id}}" data-id="{{$inscripcion->id}}" value="{{ $inscripcion->acta_volante->nota_oral != -1 ? $inscripcion->acta_volante->nota_oral : 'A' }}" {{ $cierre ? 'disabled' : '' }} pattern="(^[Aa]$)|([-]$)|([0-9]{1,2})">
                        @else
                        <input type="text" name="nota_oral" class="form-control" id="oral-{{$inscripcion->id}}" data-id="{{$inscripcion->id}}" {{ $cierre ? 'disabled' : '' }}>
                        @endif
                    </div>
                    @if($inscripcion->acta_volante)
                    <p>Promedio: <span class="badge {{ $inscripcion->acta_volante->promedio > 4 ? 'bg-success' : 'bg-danger' }}">{{ $inscripcion->acta_volante->promedio > 0 ? $inscripcion->acta_volante->promedio : 'A'}}</span></p>
                    @endif
            </div>
            <div>
                <input type="hidden" name="instancia_id" value="{{$inscripcion->mesa->instancia_id}}">
                <input type="hidden" name="materia_id" value="{{$inscripcion->materia_id}}">
                <input type="hidden" name="alumno_id" value="{{$inscripcion->alumno_id}}">
                <input type="hidden" name="mesa_alumno_id" value="{{$inscripcion->id}}">
            </div>
            <input type="submit" value="Guardar" class="btn btn-success" {{ $cierre ? 'disabled' : '' }}>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $("#ausente").change(function(e) {
        let checked = $(this).is(':checked')
        var inscripcion_id = $(this).data('id');

        if(checked)
        {
            $("#escrito-"+inscripcion_id).val('A');
            $("#escrito-"+inscripcion_id).prop('readonly',true);
            $("#oral-"+inscripcion_id).val('A');
            $("#oral-"+inscripcion_id).prop('readonly',true);
        }else{
            $("#escrito-"+inscripcion_id).val('');
            $("#escrito-"+inscripcion_id).prop('readonly',false);
            $("#oral-"+inscripcion_id).val('');
            $("#oral-"+inscripcion_id).prop('readonly',false);
        }
    });

    $("#escrito")
</script>