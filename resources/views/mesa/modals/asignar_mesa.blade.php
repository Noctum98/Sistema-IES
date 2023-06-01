<div class="modal fade" id="asignarMesa{{$inscripcion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form action="{{ route('mesas.asignar') }}" method="POST">
                    <input type="hidden" name="inscripcion_id" value="{{ $inscripcion->id }}">
                    @foreach($materia->mesas_instancias($instancia->id) as $key => $mesa)
                    <div class="form-check">
                        <input class="form-check-input" name="mesa_id"  type="radio" id="radio{{$mesa->id}}" value="{{$mesa->id}}">
                        <label class="form-check-label" for="radio{{$mesa->id}}">
                            {{$mesa->comision->nombre.' | '.date_format(new DateTime($mesa->fecha),'d-m-Y H:i')}}
                        </label>
                    </div>
                    @endforeach
                    <br>
                    <input type="submit" class="btn btn-sm btn-success" value="Asignar Mesa">
                </form>
            </div>
        </div>
    </div>
</div>