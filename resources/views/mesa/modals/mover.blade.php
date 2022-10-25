<div class="modal fade" id="mover{{$inscripcion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Mover Inscripción</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('mesa.moverComision',$inscripcion->id) }}">
                    <input type="hidden" name="mesa_id" value="{{$mesa->id}}">
                    @foreach($mesa->materia->comisiones as $key => $comision)
                    <div class="form-check">
                        <input class="form-check-input" name="comision_id" type="radio" id="radio{{$comision->id}}" value="{{$comision->id}}" {{$key == 0 ? 'checked' : ''}}>
                        <label class="form-check-label" for="radio{{$comision->id}}">
                            {{$comision->nombre}}
                        </label>
                    </div>
                    @endforeach
                    <br>
                    <input type="submit" class="btn btn-success" value="Mover">

                </form>
            </div>
        </div>
    </div>
</div>