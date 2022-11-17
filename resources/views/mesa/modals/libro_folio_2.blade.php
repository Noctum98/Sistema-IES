<div class="modal fade" id="libro_folio_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Libro Folio</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(!$mesa->cierre_profesor_segundo)
                    <p class="text-danger"><i>Para poder guardar libro y folio el profesor debe cerrar las notas.</i>
                    </p>
                @endif
                <form method="POST" action="{{ route('mesa.librofolio',$mesa->id) }}">

{{--                    <input type="hidden" name="llamado" value="{{ $llamado }}">--}}
                    <div class="form-group">
                        <label for="libro">Libro
                            <input type="text" name="libro" class="form-control" value="{{ $mesa->libro_segundo ?? '' }}">
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="libro">Folio</label>
                        <input type="text" name="folio" class="form-control" value="{{ $mesa->folio_segundo ?? '' }}">
                    </div>
                    <input type="submit" class="btn btn-success"
                           value="Guardar" {{ !$mesa->cierre_profesor_segundo ? 'disabled' : '' }}>
                </form>
            </div>
        </div>
    </div>
</div>