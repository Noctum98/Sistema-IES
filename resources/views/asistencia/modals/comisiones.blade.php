<div class="modal fade" id="eligeComision" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="exampleModalLabel">Elige la comisión</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('asis.admin',['id'=>$materia->id]) }}" method="GET">
                    @foreach($materia->comisiones as $comision)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="comision_id" id="{{$comision->id}}" value="{{$comision->id}}">
                        <label class="form-check-label" for="{{$comision->id}}">
                            {{ $comision->nombre }}
                        </label>
                    </div>
                    @endforeach
                    <hr>
                    <input type="submit" value="Guardar" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>