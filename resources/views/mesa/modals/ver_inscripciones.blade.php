<!-- Modal -->
<div class="modal fade" id="modal{{$instancia->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Elige la sede</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('sele.sede',['id'=>$instancia->id])}}">
                    @csrf
                    @if($instancia->general)
                    @foreach($sedes as $sede)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sedes" id="radio{{$sede->id}}" value="{{$sede->id}}">
                        <label class="form-check-label" for="radio{{$sede->id}}">
                            {{$sede->nombre}}
                        </label>
                    </div>
                    @endforeach
                    @else
                    @foreach($instancia->sedes as $sede)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sedes" id="radio{{$sede->id}}" value="{{$sede->id}}">
                        <label class="form-check-label" for="radio{{$sede->id}}">
                            {{$sede->nombre}}
                        </label>
                    </div>
                    @endforeach
                    @endif
                    <br>
                    <input type="submit" value="Ir a la sede" class="btn btn-sm btn-primary" {{ !$instancia->general && !$instancia->hasAnySede(Auth::user()->sedes) ? 'disabled' : '' }}>
                </form>
            </div>
        </div>
    </div>
</div>
