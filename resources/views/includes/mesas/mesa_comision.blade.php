<div class="modal fade" id="comisiones{{$materia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Mesa de {{$materia->nombre}}
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="inscripciones_comision" data-materia_id="{{ $materia->id }}" data-instancia_id="{{$instancia->id}}">
                    @foreach($materia->comisiones as $key => $comision)
                    <div class="form-check">
                        <input class="form-check-input" name="comision"  type="radio" id="radio{{$comision->id}}" value="{{$comision->id}}" {{$key == 0 ? 'checked' : ''}}>
                        <label class="form-check-label" for="radio{{$comision->id}}">
                            {{$comision->nombre}}
                        </label>
                    </div>
                    @endforeach
                    <br>
                    <input type="submit" class="btn btn-sm btn-success" value="Ir a Inscripciones">
                </form>
            </div>
        </div>
    </div>
</div>