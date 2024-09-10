<div class="modal fade" id="cierreCronograma{{ $instancia->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Cronograma de cierres</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('instancia.cierres',$instancia->id)}}">
                    @csrf
                    <div class="form-group">
                        <label for="fecha_habilitiacion">Fecha de habilitación</label>
                        <input type="date" name="fecha_habilitiacion" value="{{ $instancia->fecha_habilitiacion ?? '' }}" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label for="fecha_cierre">Fecha de cierre</label>
                        <input type="date" name="fecha_cierre" value="{{ $instancia->fecha_cierre ?? '' }}" class="form-control" required />
                    </div>

                    @if($instancia->tipo == 1)
                    <div class="form-group">
                        <label for="fecha_bajas">Fecha de habilitación bajas</label>
                        <input type="date" name="fecha_bajas" value="{{ $instancia->fecha_bajas ?? '' }}" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label for="fecha_cierre_bajas">Fecha de cierre de bajas</label>
                        <input type="date" name="fecha_cierre_bajas" value="{{ $instancia->fecha_cierre_bajas ?? '' }}" class="form-control" required />
                    </div>
                    @endif
                    <input type="submit" class="btn btn-success" value="Guardar">
                </form>
            </div>
        </div>
    </div>
</div>