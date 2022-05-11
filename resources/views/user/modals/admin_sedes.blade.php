<div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">
                    Cambiar sede de {{$user->nombre}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{route('sede_usuario',['id'=>$user->id])}}" method="POST">
                    @csrf
                    @foreach($sedes as $sede)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sedes[]" id="sede-{{$sede->id}}" value="{{$sede->id}}" {{ $user->hasSede($sede->id) ? 'checked':null }}>
                        <label class="form-check-label" for="exampleRadios{{$sede->id}}">
                            {{$sede->nombre}}
                        </label>
                    </div>
                    @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <input type="submit" class="btn btn-primary" value="Guardar cambios">
            </div>
            </form>
        </div>
    </div>
</div>
