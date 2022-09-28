<div class="modal fade" id="libro_folio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Libro Folio</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('mesa.librofolio',$mesa->id) }}">

                    <div class="form-group">
                        <label for="libro">Libro</label>
                        <input type="text" name="libro" class="form-control" value="{{ $mesa->libro ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label for="libro">Folio</label>
                        <input type="text" name="folio" class="form-control" value="{{ $mesa->folio ?? '' }}">
                    </div>
                    <input type="submit" class="btn btn-success" value="Guardar">
                </form>
            </div>
        </div>
    </div>
</div>